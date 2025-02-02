function updateCkeditor(form, datas) {
    datas.forEach(data => {
      form.set(data[1], window[
        editorGetAttr(data[0], data[1])
      ].getData());
    });
  }

  function editorGetAttr(identifier, name) {
    return 'editor_' + identifier + '_' + name;
  }