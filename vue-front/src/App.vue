<template>
  <div id="app">
    <SiteHeader :studioName="studioName"></SiteHeader>
    <router-view v-on:studioDisplayed="updateHeader"/>
  </div>
</template>

<script>
import SiteHeader from '@/components/SiteHeader'

export default {
  name: 'App',
  components: {
    SiteHeader
  },
  data() {
    return {
      studioName: ''
    }
  },
  methods: {
    updateHeader(studioName) {
      this.studioName = studioName;
    }
  },
  watch: {
    $route(to) {
      if(to.name != 'StudioSingle') {
        this.studioName = '';
      }
    }
  }
}
</script>

<style lang="scss">
// @import "@/styles/main.scss";
</style>
