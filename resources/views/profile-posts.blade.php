{{-- pass the value  --}}
<x-profile :sharedData="$sharedData" doctitle="{{ $sharedData['username']}}'s Profile" >

  <div class="list-group">
          
    
    @foreach ($posts as $item)
    {{-- GET THE posts from the components which pass a value from here to the components --}}
    <x-post :item="$item" hideAuthor />
    @endforeach
   
  </div>

</x-profile>  