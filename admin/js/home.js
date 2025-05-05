document.addEventListener("DOMContentLoaded", function () {
    $('.summernote').summernote({
      height: 250,
      toolbar: [
        ['style', ['bold', 'italic', 'underline']],
        ['para', ['ul', 'ol']],
        ['insert', ['link', 'picture']],
        ['view', ['codeview']]
      ],
      disableDragAndDrop: true,
      dialogsInBody: true
    });
  
    document.getElementById("previewBtn").addEventListener("click", function () {
      let previewHTML = '';
      document.querySelectorAll('.summernote').forEach(function (editor) {
        const label = editor.closest('.mb-4').querySelector('label').textContent;
        previewHTML += `<h5 class="text-primary mt-4">${label}</h5>`;
        previewHTML += `<div class="border p-2 mb-3">${$(editor).summernote('code')}</div>`;
      });
      document.getElementById("previewArea").innerHTML = previewHTML;
    });
  });
  