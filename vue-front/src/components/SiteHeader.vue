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
        <h3 id="studio-infos">studio</h3>
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
