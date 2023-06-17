<x-layout>

<div class="container container--narrow py-md-5">
        <h2 class="text-center mb-3">Upload a new Avatar</h2>
        <form action="/manage-avatar" method="post" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <input type="file" name="avatar" required>
                @error('avatar')
                    <div class="alert alert-danger shadow-sm">{{ $message }}</div> 
                @enderror
            </div>
            <button class="btn btn-primary">Save</button>
        </form>
</div>

</x-layout>