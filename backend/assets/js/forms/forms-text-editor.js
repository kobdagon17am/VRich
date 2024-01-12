// Markdown Editor
new SimpleMDE({
    element: document.getElementById("demo1"),
    spellChecker: false,
});

// Quill Editor
var quill = new Quill('#editor', {
    theme: 'snow'
});

// var editor = new Quill('#editor_edit', {
//     theme: 'snow'
// });