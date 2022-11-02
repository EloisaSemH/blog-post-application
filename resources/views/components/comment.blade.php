<div class="col-md-12 my-3 border-left">
    <div class="d-flex flex-column comment-section" id="{{ $comment['uuid'] }}">
        <div class="p-2">
            <div class="d-flex flex-row user-info">
                <div class="d-flex flex-column justify-content-start ml-2">
                    <span class="d-block font-weight-bold name">
                        <i class="fa fa-user-circle-o"></i>
                        {{ $comment['username'] }}
                    </span>
                    <span class="date text-black-50">
                        {{ $comment['created_at'] }}
                    </span>
                </div>
            </div>
            <div class="mt-2">
                <p class="comment-text">
                    {{ $comment['text'] }}
                </p>
            </div>
        </div>
        @if($comment['level'] < 3)
            <div class="d-flex flex-row">
                <button class="p-2 btn btn-outline-secondary" onclick="showReplyForm('{!! $comment['uuid'] !!}')">
                    <i class="fa fa-commenting-o"></i>
                    <span class="ml-1">Comment</span>
                </button>
            </div>
            <div class="row justify-content-end">
                <div class="col-md-11 py-3" id="{!! $comment['uuid'] !!}_reply" style="display: none;">
                    @include('components.comment_form')
                </div>
            </div>
        @endif
        @if(isset($comment['replays']))
            @foreach($comment['replays'] as $comment)
                <div class="row justify-content-end">
                    <div class="col-md-{{ 13 - $comment['level'] }} py-3">
                        @include('components.comment')
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
