<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\Attributes\Title;

#[Title('Profile')]
class Profile extends Component
{
    use WithFileUploads;

    public $photo = null; // Temporary file for the uploaded photo
    public $croppedImage;

    protected $listeners = [
        'cropped-photo-selected' => 'saveCroppedPhoto', // Renamed method for clarity
        'closeModal'
    ];



    public function updatedPhoto()
    {
        $validator = validator(
            ['photo' => $this->photo],
            ['photo' => 'image|max:2048']
        );

        if ($validator->fails()) {
            $this->reset('photo');
            $this->setErrorBag($validator->errors());
            $this->dispatch('$refresh'); // Opsional, untuk cepat render error
            return;
        }

        $this->dispatch('open-cropper-modal');
    }



    public function saveCroppedPhoto($dataUrl)
    {
        try {
            logger('Masuk saveCroppedPhoto');

            if (!$dataUrl) {
                throw new \Exception('Data kosong');
            }

            $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $dataUrl));

            if (!$imageData) {
                throw new \Exception('Base64 decode gagal');
            }

            $user = auth()->user();

            if ($user->profile_photo) {
                $oldPath = 'images/profile/' . $user->profile_photo;
                if (Storage::disk('public')->exists($oldPath)) {
                    Storage::disk('public')->delete($oldPath);
                    logger('Foto lama dihapus: ' . $oldPath);
                }
            }

            $fileName = 'profile_' . auth()->id() . '_' . time() . '.png';
            $path = 'images/profile/' . $fileName;

            Storage::disk('public')->put($path, $imageData);

            logger('User:', [$user]);

            $user->profile_photo = $fileName;
            $user->save();
            session()->flash('success', 'Profile photo updated successfully!');
            $this->dispatch('close-cropper-modal');
            return redirect()->route('profile.show'); // Redirect to profile page after saving

        } catch (\Exception $e) {
            session()->flash('error', 'Failed to save photo: ' . $e->getMessage());
            Log::error('Photo save error: ' . $e->getMessage());
        }
    }


    public function closeModal()
    {
        if ($this->photo) {
            try {
                $this->photo->delete();
            } catch (\Exception $e) {
                Log::error('Failed to delete temp file: ' . $e->getMessage());
            }
        }
        $this->photo = null;
    }

    public function render()
    {
        return view('livewire.user.profile');
    }
}
