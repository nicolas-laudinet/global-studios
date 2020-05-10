<template>
  <div id="page-not-found">
    <div class="item-wrapper">
      <h1>Page not found</h1>
      <h3>The page {{ currentRoute }} does not exists</h3>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return {
      currentRoute: window.location.pathname
    }
  }
}
</script>

<style lang="css" scoped>

.item-wrapper {
  text-align: center;
}

</style>
