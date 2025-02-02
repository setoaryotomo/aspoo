const {
    createApp
} = Vue;
// to load Vue files from Modules
const options_loadModule = {
  moduleCache: {
    vue: Vue
  },
  async getFile(url) {
    const res = await fetch(url);
    if (!res.ok)
      throw Object.assign(new Error(res.statusText + ' ' + url), {
        res
      });
    return {
      getContentData: asBinary => asBinary ? res.arrayBuffer() : res.text(),
    }
  },
  addStyle(textContent) {
    const style = Object.assign(document.createElement('style'), {
      textContent
    });
    const ref = document.head.getElementsByTagName('style')[0] || null;
    document.head.insertBefore(style, ref);
  },
}
const {
  loadModule
} = window['vue3-sfc-loader'];

// to map component for each modules
function componentMap(basepath, components) {
  var generatedComponents = {};
  components.forEach(component => {
    generatedComponents[component] = Vue.defineAsyncComponent(() => loadModule(basepath + component + '.vue', options_loadModule));
  });
  return generatedComponents;
}

function commonComponentMap(components) {
  var generatedComponents = {};
  components.forEach(component => {
    generatedComponents[component] = Vue.defineAsyncComponent(() => loadModule("/js/vue_component/" + component + '.vue', options_loadModule));
  });
  return generatedComponents;
}