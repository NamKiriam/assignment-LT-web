function updatePagination(totalItems) {
  const totalPages = Math.ceil(totalItems / itemsPerPage);
  let pagination = document.querySelector('.pagination');
  if (!pagination) {
      pagination = document.createElement('div');
      pagination.className = 'pagination d-flex justify-content-center gap-2 mt-3';
      document.querySelector('.question-section').appendChild(pagination);
  }
  pagination.innerHTML = '';

  // Nút Trước
  if (currentPage > 1) {
      const prevButton = document.createElement('button');
      prevButton.className = 'btn btn-outline-primary';
      prevButton.textContent = 'Trước';
      prevButton.onclick = () => {
          currentPage--;
          loadFAQs(currentPage);
      };
      pagination.appendChild(prevButton);
  }

  // Nút Sau
  if (currentPage < totalPages) {
      const nextButton = document.createElement('button');
      nextButton.className = 'btn btn-outline-primary';
      nextButton.textContent = 'Sau';
      nextButton.onclick = () => {
          currentPage++;
          loadFAQs(currentPage);
      };
      pagination.appendChild(nextButton);
  }

  // Hiển thị số trang hiện tại
  const pageInfo = document.createElement('span');
  pageInfo.className = 'ms-2 align-self-center';
  pageInfo.textContent = `Trang ${currentPage} / ${totalPages}`;
  pagination.appendChild(pageInfo);
}
