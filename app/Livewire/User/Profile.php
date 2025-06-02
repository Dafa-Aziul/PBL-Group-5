<?php

namespace App\Livewire\User;

use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;

class Profile extends Component
{
    use WithFileUploads;

    public $photo;
    public $croppedImage;

    protected $listeners = [
        'cropped-photo-selected' => 'saveCroppedPhoto', // Renamed method for clarity
        'closeModal'
    ];



    public function updatedPhoto()
    {
        $this->validate([
            'photo' => 'image|max:2048', // Max 2MB
        ]);
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
            auth()->user()->refresh();

            session()->flash('success', 'Profile photo updated successfully!');
            $this->dispatch('close-cropper-modal');
            // return redirect()->route('profile.show'); // Redirect to profile page after saving

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

        $this->dispatch('close-cropper-modal');
        $this->photo = null;
    }

    public function render()
    {
        return view('livewire.user.profile');
    }
}
