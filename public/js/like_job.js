$(function(){
    var $like = $('.btn-like'), //いいねボタンセレクタ
                likeToJobId; //投稿ID
    $like.on('click',function(e){
        e.stopPropagation();
        var $this = $(this);
        //カスタム属性（postid）に格納された投稿ID取得
        likeToJobId = $this.parents('.post').data('jobid'); 
        $.ajax({
            type: 'POST',
            url: '../LikeJob/ajaxLike.php', //post送信を受けとるphpファイル
            data: { jobId: likeToJobId} //{キー:投稿ID}
        }).done(function(data){
            console.log('Ajax Success');
            console.log();
            // いいねの総数を表示
            $this.children('span').html(data+"件");
            // いいね取り消しのスタイル
            $this.children('i').toggleClass('far fa-bookmark'); //空洞ハート
            // いいね押した時のスタイル
            $this.children('i').toggleClass('fas fa-bookmark'); //塗りつぶしハート
        }).fail(function(msg) {
            console.log('Ajax Error');
        });
    });
});
