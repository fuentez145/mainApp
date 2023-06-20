{{-- pass the value  --}}
<x-profile :sharedData="$sharedData" doctitle="{{ $sharedData['username']}}'s Followers">
  <div class="list-group">
          
    
    @foreach ($followers as $item)

    <a href="/profile/{{ $item->userDoingTheFollowing->username}}" class="list-group-item list-group-item-action">
      <img class="avatar-tiny" src="{{ $item->userDoingTheFollowing->avatar }}" />
      {{ $item->userDoingTheFollowing->username }}   
    </a>
    @endforeach
   
  </div>

</x-profile>  