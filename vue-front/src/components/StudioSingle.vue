<template>
  <div id="studio-single">
    <transition name="fade" :key="studio.id">
      <div class="item-wrapper">
        <div v-if="studioFetched" id="studio">

          <div class="nav-container">
            <div v-if="isPrevStudio()" class="left-nav-container">
              <router-link :to="{ name: 'StudioSingle', params: {id: prevStudio.id} }">
                <div class="arrow left-arrow"></div>
                <div class="prev-studio-name nav-studio-name">{{ prevStudio.name }}</div>
              </router-link>
            </div>

            <div v-if="isNextStudio()" class="right-nav-container">
              <router-link :to="{ name: 'StudioSingle', params: {id: nextStudio.id} }">
                <div class="next-studio-name nav-studio-name">{{ nextStudio.name }}</div>
                <div class="arrow right-arrow"></div>
              </router-link>
            </div>
          </div>

          <h2>{{ studio.name }}</h2>
          <div class="stroke"></div>
          <h3 class="studio-country">{{ studio.country }}</h3>
          <p class="studio-description">{{ studio.description }}</p>

          <img
            :src="rootURL + '/images/' + studioFeaturedWork.img_path"
            :alt="studioFeaturedWork.alt_text"
          >

          <h3 class="work-name">{{ studioFeaturedWork.title }}</h3>

          <p class="featured-descr">{{ studioFeaturedWork.description }}</p>

          <div class="studio-works">
            <div class="work-container" v-for="work in studio.works" v-bind:key="work.id">
              <img
                class="studio-work-img single-studio"
                :src="rootURL + '/images/' + work.img_path"
                :alt="work.alt_text"
              >

              <div class="work-text">
                <h3 class="work-name">{{ work.title }}</h3>
                <p class="work-descr">{{ work.description }}</p>
              </div>
            </div>
          </div>

        </div>
      </div>
    </transition>
  </div>
</template>

<script>
export default {
  data() {
    return {
      studioFetched: false,
      studio: {},
      studioFeaturedWork: [],
      allStudios: [],
      prevStudio: {},
      nextStudio: {},
      rootURL: process.env.VUE_APP_ROOT
    }
  },
  methods: {
    isPrevStudio() {
      let isPreviousStudio = false;

      this.allStudios.forEach((studio, index, studios) => {
        if(studios[index - 1]) {
          if(this.studio.id === studio.id) {
            this.prevStudio = studios[index - 1];
            isPreviousStudio = true;
          }
        }
      });

      return isPreviousStudio;
    },
    isNextStudio() {
      let isNextStudio = false;

      this.allStudios.forEach((studio, index, studios) => {
        if(studios[index + 1]) {
          if(this.studio.id === studio.id) {
            this.nextStudio = studios[index + 1];
            isNextStudio = true;
          }
        }
      });

      return isNextStudio;
    },
    getFeaturedWork(studio) {
      return  studio.works.filter((work) => {
        return work.featured == 1;
      })
    },
    fetchStudio() {
      fetch(`${process.env.VUE_APP_ROOT}/api/studios.php?id=${this.$route.params.id}`, {mode: 'cors'})
      .then((response) => {
        response.json().then((studio) => {
          this.studio = studio[0];
          this.studioFetched = true;

          this.sortStudioWorks();
          this.emitStudioData(this.studio.name);
        });
      });
    },
    fetchAllStudios() {
      fetch(`${process.env.VUE_APP_ROOT}/api/studios.php`, {mode: 'cors'})
      .then((response) => {
        response.json().then((studios) => {
          //tri les studios par date d'ajout au site
          studios.sort((a, b) => {
            if(a.added_at > b.added_at) return 1;
            if(a.added_at < b.added_at) return -1;
            if(a.added_at === b.added_at) return 0;
          });

          //extrait au hasard un element du tableau
          // this.featuredStudio = studios.splice(Math.floor(Math.random() * studios.length), 1)[0];

          this.allStudios = studios;
          // this.fetched = true;
        });
      });
    },
    sortStudioWorks() {
      let index = this.studio.works.findIndex(work => work.featured == 1);
      this.studioFeaturedWork = this.studio.works.splice(index, 1)[0];
    },
    emitStudioData(studioName) {
      this.$emit('studioDisplayed', studioName);
    }
  },
  created() {
    this.fetchStudio();
    this.fetchAllStudios();
  },
  watch: {
    $route() {
      this.fetchStudio();
      document.querySelector('html').scrollTop = 0;
    }
  }
}
</script>
