<?php

namespace App\Livewire\User;

use App\Models\Review;
use Livewire\Component;

class ReviewComponent extends Component
{
    public $user;
    public $rating, $review;
    public function mount()
    {
        $this->user = auth()->user();
    }
    public function updateReview($id)
    {
        $validatedData = $this->validate([
            'rating' => 'required',
            'review' => 'required',
        ]);

        $review = Review::find($id);
        if (!$review) {
            session()->flash('error', __('Review not found.'));
            return;
        }
        $review->rating = $this->rating;
        $review->review = $this->review;
        if ($review->save()) {
            session()->flash('success', __('Review has been updated successfully!'));
        } else {
            session()->flash('error', __('Something went wrong!'));
        }
    }
    public function render()
    {
        return view('livewire.user.review-component');
    }
}
