<?php

namespace App\Livewire\User;

use App\Models\Wishlist;
use Livewire\Component;

class WishListComponent extends Component
{
    public function removeWishlist($id)
    {
        $wishlist = Wishlist::find($id);
        if($wishlist->delete())
            session()->flash('success', __('Product has been removed from wishlist successfully!'));
        else
            session()->flash('error', __('Something went wrong!'));
    }
    public function clearAllWishlist()
    {
        $wishlists = Wishlist::where('user_id', auth()->user()->id)->get();
        foreach($wishlists as $wishlist)
        {
            $wishlist->delete();
        }
        session()->flash('success', __('Wishlist has been cleared successfully!'));
    }
    public function render()
    {
        $wishlists = Wishlist::where('user_id', auth()->user()->id)->get();
        return view('livewire.user.wish-list-component', ['wishlists' => $wishlists]);
    }
}
