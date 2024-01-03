const replyButtons = document.querySelectorAll('.reply-button');
replyButtons.forEach(button => {
    button.addEventListener('click', () => {
        let messageId = button.dataset.messageId;
        console.log(messageId);
        let replyForm = document.getElementById(reply-form-${messageId});
        console.log(replyForm);
        replyForm.style.display = 'block';
    });
});
