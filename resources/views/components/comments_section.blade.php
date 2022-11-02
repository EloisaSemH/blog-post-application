<aside class="">
    <hr class="my-3">
    <h3 class="mb-3">Comments</h3>
    @include('components.comment_form')
    <div class="d-flex justify-content-center row">
        @foreach($comments as $comment)
            @include('components.comment')
        @endforeach
    </div>
</aside>
@section('js')
    <script>
        function showReplyForm(elementId) {
            let replyForm = document.getElementById(elementId + "_reply");
            let replyLevel = document.getElementById(elementId + "_level");
            let replyLevelValue = replyLevel.value;
            console.log(replyLevel)
            console.log(replyLevelValue)
            if (replyForm.style.display === "none") {
                replyForm.style.display = "block";
                replyLevel.value = +replyLevelValue + 1;
            } else {
                replyForm.style.display = "none";
                replyLevel.value = +replyLevelValue - 1;
            }
        }
    </script>
@endsection
