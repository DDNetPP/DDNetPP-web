document.querySelector('#chat-form').addEventListener('submit', event => {
  event.preventDefault()
  const message = document.querySelector('#message').value
  const formData = new FormData()
  formData.append('message', message)
  fetch('post.php', {
    method: 'POST',
    body: formData
  }).then(r => console.log(r))
})
