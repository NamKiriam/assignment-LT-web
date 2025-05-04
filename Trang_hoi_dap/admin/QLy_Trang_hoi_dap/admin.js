document.addEventListener('DOMContentLoaded', () => {
  const commentList = document.getElementById('comment-list');
  const contactList = document.getElementById('contact-list');
  const commentPagination = document.getElementById('comment-pagination');
  const contactPagination = document.getElementById('contact-pagination');
  const commentsSection = document.getElementById('comments-section');
  const contactsSection = document.getElementById('contacts-section');
  const pageHeading = document.querySelector('.page-heading h3');
  const sidebarLinks = document.querySelectorAll('.sidebar-link');

  // Cấu hình phân trang
  const itemsPerPage = 5;
  let currentCommentPage = 1;
  let currentContactPage = 1;
  let comments = [];
  let contacts = [];

  // Lấy dữ liệu từ localStorage
  function loadData() {
      const savedComments = localStorage.getItem('adminComments');
      const savedContacts = localStorage.getItem('adminContacts');
      comments = savedComments ? JSON.parse(savedComments) : [
          { id: 1, user: 'User1', content: 'Sản phẩm rất tốt!', product: 'Sản phẩm A', date: 'May 03, 15:00', approved: false },
          { id: 2, user: 'User2', content: 'Giao hàng chậm quá.', product: 'Sản phẩm B', date: 'May 02, 10:30', approved: true }
      ];
      contacts = savedContacts ? JSON.parse(savedContacts) : [
          { id: 1, name: 'Nguyen Van A', email: 'a@example.com', message: 'Tôi muốn hỏi về sản phẩm A.', date: 'May 03, 14:00' },
          { id: 2, name: 'Tran Thi B', email: 'b@example.com', message: 'Liên hệ báo giá.', date: 'May 02, 09:00' }
      ];
  }

  // Lưu dữ liệu vào localStorage
  function saveData() {
      localStorage.setItem('adminComments', JSON.stringify(comments));
      localStorage.setItem('adminContacts', JSON.stringify(contacts));
  }

  // Hiển thị danh sách bình luận
  function displayComments(page) {
      commentList.innerHTML = '';
      const start = (page - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      const paginatedComments = comments.slice(start, end);

      paginatedComments.forEach((comment, index) => {
          const commentCard = document.createElement('div');
          commentCard.className = 'col-12 comment-card';
          commentCard.innerHTML = `
              <div class="card">
                  <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                          <div>
                              <h5>${comment.user} - ${comment.product}</h5>
                              <p class="mb-1">${comment.content}</p>
                              <small class="text-muted">${comment.date}</small>
                          </div>
                          <div>
                              <button class="btn btn-sm btn-${comment.approved ? 'success' : 'warning'} approve-btn" data-index="${start + index}">
                                  ${comment.approved ? 'Đã duyệt' : 'Duyệt'}
                              </button>
                              <button class="btn btn-sm btn-danger delete-btn" data-index="${start + index}">Xóa</button>
                          </div>
                      </div>
                  </div>
              </div>
          `;
          commentList.appendChild(commentCard);
      });

      document.querySelectorAll('.approve-btn').forEach(button => {
          button.addEventListener('click', (e) => {
              const index = parseInt(e.target.getAttribute('data-index'));
              approveComment(index);
          });
      });

      document.querySelectorAll('.delete-btn').forEach(button => {
          button.addEventListener('click', (e) => {
              const index = parseInt(e.target.getAttribute('data-index'));
              deleteComment(index);
          });
      });

      updateCommentPagination();
  }

  // Hiển thị danh sách liên hệ
  function displayContacts(page) {
      contactList.innerHTML = '';
      const start = (page - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      const paginatedContacts = contacts.slice(start, end);

      paginatedContacts.forEach((contact, index) => {
          const contactCard = document.createElement('div');
          contactCard.className = 'col-12 contact-card';
          contactCard.innerHTML = `
              <div class="card">
                  <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                          <div>
                              <h5>${contact.name}</h5>
                              <p class="mb-1">Email: ${contact.email}</p>
                              <p class="mb-1">Tin nhắn: ${contact.message}</p>
                              <small class="text-muted">${contact.date}</small>
                          </div>
                          <div>
                              <button class="btn btn-sm btn-danger delete-btn" data-index="${start + index}">Xóa</button>
                          </div>
                      </div>
                  </div>
              </div>
          `;
          contactList.appendChild(contactCard);
      });

      document.querySelectorAll('.delete-btn').forEach(button => {
          button.addEventListener('click', (e) => {
              const index = parseInt(e.target.getAttribute('data-index'));
              deleteContact(index);
          });
      });

      updateContactPagination();
  }

  // Duyệt bình luận
  function approveComment(index) {
      if (confirm('Bạn có muốn duyệt bình luận này?')) {
          comments[index].approved = true;
          saveData();
          displayComments(currentCommentPage);
      }
  }

  // Xóa bình luận
  function deleteComment(index) {
      if (confirm('Bạn có chắc chắn muốn xóa bình luận này?')) {
          comments.splice(index, 1);
          saveData();
          const totalPages = Math.ceil(comments.length / itemsPerPage);
          if (currentCommentPage > totalPages && totalPages > 0) {
              currentCommentPage = totalPages;
          } else if (comments.length === 0) {
              currentCommentPage = 1;
          }
          displayComments(currentCommentPage);
      }
  }

  // Xóa liên hệ
  function deleteContact(index) {
      if (confirm('Bạn có chắc chắn muốn xóa liên hệ này?')) {
          contacts.splice(index, 1);
          saveData();
          const totalPages = Math.ceil(contacts.length / itemsPerPage);
          if (currentContactPage > totalPages && totalPages > 0) {
              currentContactPage = totalPages;
          } else if (contacts.length === 0) {
              currentContactPage = 1;
          }
          displayContacts(currentContactPage);
      }
  }

  // Cập nhật phân trang cho bình luận
  function updateCommentPagination() {
      const totalPages = Math.ceil(comments.length / itemsPerPage);
      commentPagination.innerHTML = '';

      const ul = document.createElement('ul');
      ul.className = 'pagination';

      if (currentCommentPage > 1) {
          const prevLi = document.createElement('li');
          prevLi.className = 'page-item';
          prevLi.innerHTML = '<a class="page-link" href="#">Trước</a>';
          prevLi.addEventListener('click', (e) => {
              e.preventDefault();
              currentCommentPage--;
              displayComments(currentCommentPage);
          });
          ul.appendChild(prevLi);
      }

      for (let i = 1; i <= totalPages; i++) {
          const li = document.createElement('li');
          li.className = `page-item ${i === currentCommentPage ? 'active' : ''}`;
          li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
          li.addEventListener('click', (e) => {
              e.preventDefault();
              currentCommentPage = i;
              displayComments(currentCommentPage);
          });
          ul.appendChild(li);
      }

      if (currentCommentPage < totalPages) {
          const nextLi = document.createElement('li');
          nextLi.className = 'page-item';
          nextLi.innerHTML = '<a class="page-link" href="#">Sau</a>';
          nextLi.addEventListener('click', (e) => {
              e.preventDefault();
              currentCommentPage++;
              displayComments(currentCommentPage);
          });
          ul.appendChild(nextLi);
      }

      commentPagination.appendChild(ul);
  }

  // Cập nhật phân trang cho liên hệ
  function updateContactPagination() {
      const totalPages = Math.ceil(contacts.length / itemsPerPage);
      contactPagination.innerHTML = '';

      const ul = document.createElement('ul');
      ul.className = 'pagination';

      if (currentContactPage > 1) {
          const prevLi = document.createElement('li');
          prevLi.className = 'page-item';
          prevLi.innerHTML = '<a class="page-link" href="#">Trước</a>';
          prevLi.addEventListener('click', (e) => {
              e.preventDefault();
              currentContactPage--;
              displayContacts(currentContactPage);
          });
          ul.appendChild(prevLi);
      }

      for (let i = 1; i <= totalPages; i++) {
          const li = document.createElement('li');
          li.className = `page-item ${i === currentContactPage ? 'active' : ''}`;
          li.innerHTML = `<a class="page-link" href="#">${i}</a>`;
          li.addEventListener('click', (e) => {
              e.preventDefault();
              currentContactPage = i;
              displayContacts(currentContactPage);
          });
          ul.appendChild(li);
      }

      if (currentContactPage < totalPages) {
          const nextLi = document.createElement('li');
          nextLi.className = 'page-item';
          nextLi.innerHTML = '<a class="page-link" href="#">Sau</a>';
          nextLi.addEventListener('click', (e) => {
              e.preventDefault();
              currentContactPage++;
              displayContacts(currentContactPage);
          });
          ul.appendChild(nextLi);
      }

      contactPagination.appendChild(ul);
  }

  // Chuyển đổi section khi click vào sidebar
  sidebarLinks.forEach(link => {
      link.addEventListener('click', (e) => {
          e.preventDefault();
          sidebarLinks.forEach(l => l.parentElement.classList.remove('active'));
          link.parentElement.classList.add('active');

          const section = link.getAttribute('data-section');
          if (section === 'comments') {
              commentsSection.style.display = 'block';
              contactsSection.style.display = 'none';
              pageHeading.textContent = 'Quản lý bình luận';
              displayComments(currentCommentPage);
          } else if (section === 'contacts') {
              commentsSection.style.display = 'none';
              contactsSection.style.display = 'block';
              pageHeading.textContent = 'Quản lý liên hệ';
              displayContacts(currentContactPage);
          }
      });
  });

  // Tải dữ liệu và hiển thị ban đầu
  loadData();
  displayComments(currentCommentPage);
});