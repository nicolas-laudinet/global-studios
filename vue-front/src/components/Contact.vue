<template lang="html">
  <div id="contact" class="item-wrapper">
    <div class="message"></div>

    <h2>Contact Us</h2>

    <form @submit.prevent="submitMessage()">
      <div class="input-container">
        <label for="name">Name</label>
        <br>
        <input type="text" name="name" id="name">
      </div>


      <div class="input-container">
        <label for="mail">Mail</label>
        <br>
        <input type="mail" name="mail" id="mail">
      </div>


      <div class="input-container">
        <label for="body">Your message</label>
        <br>
        <textarea name="body" rows="8" cols="80"></textarea>
      </div>


      <div class="input-container">
        <input type="submit" value="Submit">
      </div>
    </form>
  </div>
</template>

<script>
export default {
  methods: {
    submitMessage() {
      let message = document.querySelector('.message');

      var form = new FormData(document.querySelector('form'));
      let params = { method: 'POST', mode: 'cors', body: form };
      fetch('http://global-studios.test/api/messages.php', params)
      .then((response) => {
        response.json().then((json) => {
          if(json.success) {
            message.innerHTML = json.message;
            message.classList.add('message-success');

            setTimeout(() => {
              message.classList.add('message-transition');

              setTimeout(() => {
                message.classList.remove('message-transition');
                message.classList.remove('message-success');
              }, 5000);

            }, 2500);

          } else {
            console.log(json.message)
            message.innerHTML = json.message;
            message.classList.add('message-error');

            setTimeout(() => {
              message.classList.add('message-transition');

              setTimeout(() => {
                message.classList.remove('message-transition');
                message.classList.remove('message-error');
              }, 5000);

            }, 2500);
          }
        })
      });
    }
  }
}
</script>

<style lang="css">

</style>
