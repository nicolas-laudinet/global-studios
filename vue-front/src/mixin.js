export default {
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
