<template>
  <div id="featured-studio" class="item-wrapper">
    <!-- <div class="stroke"></div> -->
    <h2>Featured Studio</h2>
    <div class="stroke"></div>
    <h3 id="studio-name">{{ featuredStudio.name }}</h3>
    <p class="country">{{ featuredStudio.country.toUpperCase() }}</p>

    <div
      :class="{'featured-container': true, isHovering: isHovering}"
      @mouseover="isHovering = true"
      @mouseout="isHovering = false"
    >

      <img
        class="featured-studio-img"
        :src="rootURL + '/images/' + featuredWork.img_path"
        :alt="featuredWork.alt_text"
        :title="featuredWork.title"
      >

      <div class="featured-text">
        <p>{{ featuredStudio.description.slice(0, 300) }} [...]
          <router-link :to="{ name: 'StudioSingle', params: {id: featuredStudio.id} }">
            <i class="read-more">Read more</i>
          </router-link>
        </p>
      </div>

    </div>
  </div>
</template>

<script>
export default {
  name: 'Featured',
  props: ['featuredStudio'],
  data () {
    return {
      isHovering: false,
      rootURL: process.env.VUE_APP_ROOT
    }
  },
  computed: {
    featuredWork() {
      let featuredWork = {};
      let works = this.featuredStudio.works;
      for(let i = 0; i < works.length; i++) {
        if(works[i].featured == 1) {
          featuredWork = works[i];
        }
      }
      return featuredWork;
    }
  }
}
</script>
