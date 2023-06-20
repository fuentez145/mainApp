{{-- pass the value  --}}
<x-profile :sharedData="$sharedData" doctitle="{{ $sharedData['username']}}'s Following" >
  <div class="list-group">
          
  {{-- following / where the name being pass from the controller --}}
    @foreach ($following as $item)
    <a href="/profile/{{ $item->userBeingFollowed->username}}" class="list-group-item list-group-item-action">
      <img class="avatar-tiny" src="{{ $item->userBeingFollowed->avatar }}" />
      {{ $item->userBeingFollowed->username }}
    </a>
    @endforeach
   
  </div>

</x-profile>  