<?php
function drawNestedComments($comments, $nested = 0) {

    $isNested = $nested > 0;
    $offset = 81*$nested;
    $nested++;
    foreach ($comments as $comment) {
        echo '
        <div class="nested-container">
            <div style="left: '.$offset.'px;" class="'.($isNested?'nested':'').' d-flex flex-start mb-4 comment-container">
                <img
                        class="rounded-circle shadow-1-strong me-3"
                        src="https://i.pravatar.cc/'. rand(65, 80).'"
                        alt="avatar"
                        width="65"
                        height="65"
                />
                <div class="card w-100 comment" id="comment-id-'.$comment['id'].'">
                    <div class="card-body p-4">
                        <div class="">
                            <h5 class="title">Comment id-'.$comment['id'].'</h5>
                            <p class="small datetime">'.$comment['created_at'].'</p>
                            <p class="body">
                                '.$comment['body'].'
                            </p>
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center replied-to '.($comment['parent_id']?'':'invisible').'">Replied to
                                    <a href="#comment-id-'.$comment['parent_id'].'" class="link-muted me-2 link-reply">
                                        <i class="me-1"></i>Comment id-'.$comment['parent_id'].'
                                    </a>
                                </div>
                                <a href="#!" class="link-muted reply" data-replied-to="'.$comment['id'].'"><i class="fas fa-reply me-1"></i> Reply</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        ';
        if (isset($comment['childs'])) {
            drawNestedComments($comment['childs'], $nested);
        }
        echo
        '</div>';
    }
}
?>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.14.0/css/all.min.css" rel="stylesheet" >
    <link href="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css" rel="stylesheet">

    <title>Comments application</title>
    <style>
        .nested {
            position: relative;
            /*left: 81px;*/
        }
        .nested::before {
            width: 45px;
            height: 171px;
            position: absolute;
            left: -48px;
            top: -138px;
            content: "";
            background: none;
            border: 1px solid #bdd5ff;
            border-right: 0px;
            border-top: 0px;
        }
        .comment:target {
            box-shadow: 0px 0px 9px 6px #c1b1ff;
            border-radius: 3px;
            transition: .5s;
        }
        a {
            color: #8285ff;
        }
    </style>
</head>
<body data-topic-id="<?=$topicId?>">

<section style="background: linear-gradient(160grad, #e4f2ff 30%, #f2e7fd 70%);">
    <div class="container my-5 py-5 text-dark">
        <div class="row d-flex justify-content-center">
            <div class="col-md-11 col-lg-9 col-xl-7">
                <?php drawNestedComments($comments);?>
            </div>
        </div>
    </div>
</section>

<div style="display:none !important;" class="nested comment-form-template d-flex flex-start mb-4">
    <img class="rounded-circle shadow-1-strong me-3" src="https://i.pravatar.cc/65" alt="avatar" width="65" height="65">
    <div class="card w-100 comment" >
        <div class="card-body p-4">
            <div class="mb-3">
                <textarea class="form-control comment-text" class="comment-body" rows="3"></textarea>
            </div><button type="submit" class="btn btn-primary pull-right comment-send">Submit</button></div>
    </div>
</div>

<div style="display:none !important;"  class="nested-container comment-container-template">
    <div class="d-flex flex-start mb-4 comment-container nested">
        <img
            class="rounded-circle shadow-1-strong me-3"
            src="https://i.pravatar.cc/<?= rand(65, 80) ?>"
            alt="avatar"
            width="65"
            height="65"
        />
        <div class="card w-100 comment" id="">
            <div class="card-body p-4">
                <div class="">
                    <h5 class="title">Comment id-</h5>
                    <p class="small datetime"></p>
                    <p class="body"></p>
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center replied-to"> Replied to
                            <a href="#" class="link-muted me-2 link-reply">
                                <i class="me-1"></i><span>Comment id-</span>
                            </a>
                        </div>
                        <a href="#" class="link-muted reply" data-replied-to="">
                            <i class="fas fa-reply me-1"></i> Reply
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<script>
$('body').on('click', '.reply',(e)=>{
    e.preventDefault();
    e.stopPropagation();
    $(".comment-form").remove();
    let button = $(e.currentTarget);
    let repliedTo = button.data('replied-to');
    let cloneCommentForm = $(".comment-form-template").clone();
    let parentComment = button.closest('.comment-container');
    let parentOffset =  parentComment.css('left').match(/\d*/)[0];
    let leftCss = (parseInt(parentOffset) + 81) + 'px';
    cloneCommentForm.find('.comment-send').attr('data-replied-to',repliedTo);
    cloneCommentForm.addClass("comment-form");
    cloneCommentForm.removeClass("comment-form-template")
    cloneCommentForm.removeAttr('style');
    cloneCommentForm.css('left',leftCss);
    parentComment.after(cloneCommentForm);
});

$('body').on('click', '.comment-send', (e)=>{

    let commentForm = $(e.currentTarget).closest('.comment-form');

    let body = commentForm.find('.comment-text').val();

    let data = {
        parent_id: $(e.currentTarget).data('replied-to'),
        body: body,
        topic_id: $('body').data('topic-id')
    };

    fetch('/insert_comment.php', {
        method: 'POST',
        body: JSON.stringify(data)
    }).then(res => {
            if (res.status !== 200) {
                toastr["error"]("Server error");
            } else {
                toastr["success"]("Comment created successfully");
            }
    })

    commentForm.remove();
})

function lastReplyComment(parent_id) {
    return $('#comment-id-'+parent_id).closest('.nested-container').find('.nested-container').last()
}

function drawNewComment(id, body, parent_id, created_at) {
    let cloneCommentContainer = $(".comment-container-template").clone();
    let parentComment = $('#comment-id-'+parent_id).closest('.comment-container');
    let parentOffset = parseInt(parentComment.css('left'))?parseInt(parentComment.css('left')):0;
    let leftCss = (parentOffset + 81) + 'px';

    cloneCommentContainer.find('.title').text(' Comment id-'+id);
    cloneCommentContainer.find('.datetime').text(created_at);
    cloneCommentContainer.find('.body').text(body);
    cloneCommentContainer.find('.link-reply span').text('Comment id-'+parent_id);
    cloneCommentContainer.find('.link-reply').attr('href','#comment-id-'+parent_id);
    cloneCommentContainer.find('.reply').attr('data-replied-to', id);
    cloneCommentContainer.find('.comment').attr('id', 'comment-id-'+id);
    cloneCommentContainer.removeAttr('style');
    cloneCommentContainer.removeClass("comment-container-template")
    cloneCommentContainer.find('.comment-container').css('left',leftCss);

    parentComment.closest('.nested-container').append(cloneCommentContainer)
}

function drawNewCommentsFetch(){
    getNewComments(drawNewComment);
}

function getNewComments(callback) {
    fetch('/get_new_comments.php', {
        method: 'POST',
        body: getLastDatetime()
    }).then(res => res.json())
    .then(comments => {
        debugger;
        comments.forEach((comment) => {
            debugger;
            callback(comment.id, comment.body, comment.parent_id, comment.created_at);
        });
    })
}

function getLastDatetime() {
    let maxTimestamp = 0;
    $('.datetime').each((index, element) => {

        let nextTimestamp = Math.round(new Date(element.textContent).getTime()/1000)

        if (nextTimestamp > maxTimestamp) {
            maxTimestamp = nextTimestamp
        }

    })
    return maxTimestamp

}

setInterval(drawNewCommentsFetch,500)

</script>
</body>
</html>