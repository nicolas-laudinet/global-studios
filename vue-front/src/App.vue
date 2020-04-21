<template>
  <div id="app">
    <SiteHeader></SiteHeader>
    <router-view/>
  </div>
</template>

<script>
import SiteHeader from '@/components/SiteHeader'

export default {
  name: 'App',
  components: {
    SiteHeader
  }
}
</script>

<style lang="scss">
// @import "@/styles/main.scss";
</style>
