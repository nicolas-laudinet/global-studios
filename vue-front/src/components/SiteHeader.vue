<template>
  <header>
    <div id="header-logo">
      <router-link to="/">
        <img id="gs-logo" src="../assets/gs-logo.png" alt="Global Studios Logo">
      </router-link>
    </div>

    <div id="menu-container">
      <nav>
        <ul id="menu-list">
          <li v-for="(element, idx) in menu" v-bind:key="idx">
            <router-link :to="element.url">
              {{ element.title }}
            </router-link>
          </li>
        </ul>
      </nav>

      <div class="header-stroke"></div>

      <div id="current-studio">
        <transition name="fade">
          <h3 v-if="studioName" id="studio-infos" :key="studioName">{{ studioName }}</h3>
        </transition>
      </div>
    </div>

    <div class="menu-burger">
      <img src="../assets/menu.png" alt="">
    </div>

  </header>
</template>

<script>
export default {
  name: 'SiteHeader',
  props: {
    studioName: String
  },
  data () {
    return {
      msg: '! Header !',
      menu: [
        {
          title: 'Studios List',
          url: '/list'
        },
        {
          title: 'Contact',
          url: '/contact'
        },
        {
          title: 'About',
          url: '/about'
        }
      ]
    }
  }
}
</script>

<style lang="scss">

</style>
