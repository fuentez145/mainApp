
<x-layout>
<div class="container py-md-5 container--narrow">
    <h2>
      <img class="avatar-small" src="{{ $avatar}}" /> {{ $username }}
      <form class="ml-2 d-inline" action="#" method="POST">
        <button class="btn btn-primary btn-sm">Follow <i class="fas fa-user-plus"></i></button>
      <!--  <button class="btn btn-danger btn-sm">Stop Following <i class="fas fa-user-times"></i></button> --> 
        @if (auth()->user()->username == $username)
           <a href="/manage-avatar" class="btn btn-secondary btn-sm">Manage Avatar</a>
          
        @endif
      </form>
    </h2>

    <div class="profile-nav nav nav-tabs pt-2 mb-4">
      <a href="#" class="profile-nav-link nav-item nav-link active">Posts: {{ $postCount}}</a>
      <a href="#" class="profile-nav-link nav-item nav-link">Followers: 3</a>
      <a href="#" class="profile-nav-link nav-item nav-link">Following: 2</a>
    </div>

    <div class="list-group">
      

      @foreach ($posts as $item)
      <a href="/post/{{$item['id']}}" class="list-group-item list-group-item-action">
        <img class="avatar-tiny" src="{{ $item->user->avatar }}" />
        <strong>{{$item['title']}} </strong> on {{ $item['created_at']->format('d/m/Y ') }}
      </a>
      @endforeach
     
    </div>
  </div>

</x-layout>