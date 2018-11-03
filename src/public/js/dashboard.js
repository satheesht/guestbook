$(function(){
    $(".viewReplies").click(function(e){
        e.preventDefault();
        var messageId = $(this).data("id");
        refreshReplies(messageId);

    });

    $(".reply").click(function(){
        var messageId = $(this).data("id");
        var message = $("#replyMessageBox-"+messageId).val();
        $.ajax({
            url:"/replyMessage",
            method: "post",
            data:{id:messageId, message:message},
            success: function(result){
                renderRepliesFromResult(result, messageId);
            }
        });
    });

    $(".delete").click(function(){
        var messageId = $(this).data("id");
        console.log(messageId);
        $.ajax({
            url:"/message",
            method: "delete",
            data:{id:messageId},
            success: function(result){
                location.reload(1);
            }
        });
    });

    function refreshReplies(messageId){
        $.ajax({
            url: "/getReplies",
            data: {messageId:messageId},
            success: function(result){
                if(result){
                    renderRepliesFromResult(result,messageId);
                }
            }
        });
    }

    function renderRepliesFromResult(result, messageId){
        result = JSON.parse(result);
        var template = '';
        for(var i=0;i<result.length;i++){

            template +=
                '<div>'+
                '<div class="media text-muted pt-3">'+
                '<p class="media-body pb-3 mb-0 small lh-125">'+
                '<strong class="d-block text-gray-dark">'+result[i][2]+' '+result[i][3]+'</strong>'+
                result[i][0]+
                '</p>'+
                '</div>'+
                '</div>';
        }
        $("#reppliesList-"+messageId).fadeIn().find(".content").html(template);
    }



});
