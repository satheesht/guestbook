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

    $(".delete").click(function(e){
        e.preventDefault();
        var messageId = $(this).data("id");
        console.log(messageId);
        $.ajax({
            url:"/message?id="+messageId,
            method: "delete",
            success: function(){
                location.reload(1);
            }
        });
    });

    $("#newMessageSubmit").click(function(e){
        e.preventDefault();
        var message = $("#newMessageTextarea").val();
        var messageId = $("#newMessageTextarea").data("update-id");
        var method = messageId?"put":"post";
        $.ajax({
            url: "/message",
            method: method,
            data: JSON.stringify({message:message, id:messageId}),
            contentType: "application/json; charset=utf-8",
            dataType: "json",
            success: function(){
                window.location.reload(1);
            }
        });
    });

    $(".edit").click(function(e){
        e.preventDefault();
        var messageId = $(this).data("id");
        var message = $(this).data("message");
        $("#newMessageSubmit").html("Update");
        $("#newMessageTextarea")
            .data("update-id", messageId)
            .val(message)
            .focus();

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
                '<strong class="d-block text-gray-dark">'+htmlEntities(result[i][2])+' '+htmlEntities(result[i][3])+'</strong>'+
                htmlEntities(result[i][0])+
                '</p>'+
                '</div>'+
                '</div>';
        }
        $("#reppliesList-"+messageId).fadeIn().find(".content").html(template);
    }

    function htmlEntities(str) {
        return String(str).replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;').replace(/"/g, '&quot;');
    }



});
