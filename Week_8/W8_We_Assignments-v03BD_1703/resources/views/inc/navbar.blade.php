<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-dark border-bottom shadow-sm">
    <h5 class="my-0 mr-md-auto font-weight-normal text-white">{{config('app.name','M-Blogs')}}</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-white" href="{{config('app.url')}}/">Home</a>
        <a class="p-2 text-white" href="{{config('app.url')}}/posts">Posts</a>
        <a class="p-2 text-white" href="{{config('app.url')}}/posts/create">New Post</a>
    </nav>
    <a class="btn btn-outline-primary" href="#">Log in</a>
</div>