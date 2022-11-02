<form class="mb-3" action="{!! route('comment.save') !!}" method="post">
    <input type="hidden" name="uuid" value="{!! isset($comment) ? $comment['uuid'] : $post['uuid'] !!}">
    <input type="hidden" name="level" value="{!! isset($comment) ? $comment['level'] : 1 !!}" id="{!! isset($comment) ? $comment['uuid'] : $post['uuid'] !!}_level">
    <input type="hidden" name="_method" value="post">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="m-0">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="form-group row">
        <label for="username" class="col-md-2 col-lg-1 col-form-label">Username</label>
        <div class="col-md-10 col-lg-11">
            <input type="text" class="form-control" id="username" name="username" placeholder="Darth Vader"
                   value="{!! old('username', '') !!}" style="max-width: 300px">
        </div>
    </div>
    <div class="form-group">
        <label for="comment">Comment</label>
        <textarea class="form-control" id="comment" name="comment" rows="3"></textarea>
    </div>
    <div class="form-group text-right">
    <input type="submit" class="btn btn-dark" value="Submit">
    </div>
</form>
