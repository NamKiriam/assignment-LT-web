document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('question-form');
  const questionList = document.getElementById('question-list');
  const pagination = document.getElementById('pagination');
  const nameInput = document.getElementById('question-name');

  // Cấu hình phân trang
  const itemsPerPage = 4; // Số câu hỏi mỗi trang
  let currentPage = 1; // Trang hiện tại
  let questions = []; // Mảng lưu trữ tất cả câu hỏi
  let currentUser = null; // Lưu tên người dùng hiện tại

  // Lấy hoặc lưu tên người dùng vào localStorage
  function setCurrentUser(name) {
      if (!currentUser) {
          currentUser = name;
          localStorage.setItem('currentUser', name);
          nameInput.value = name; // Điền sẵn tên vào input
          nameInput.disabled = true; // Không cho phép thay đổi tên
      }
  }

  // Lấy tên người dùng từ localStorage khi tải trang
  if (localStorage.getItem('currentUser')) {
      currentUser = localStorage.getItem('currentUser');
      nameInput.value = currentUser;
      nameInput.disabled = true;
  }

  // Hàm hiển thị danh sách câu hỏi theo trang
  function displayQuestions(page) {
      questionList.innerHTML = ''; // Xóa danh sách hiện tại
      const start = (page - 1) * itemsPerPage;
      const end = start + itemsPerPage;
      const paginatedQuestions = questions.slice(start, end);

      paginatedQuestions.forEach((question, index) => {
          const questionCard = document.createElement('div');
          questionCard.className = 'question-card';
          const isCurrentUser = question.name === currentUser; // Kiểm tra xem câu hỏi có phải của người dùng hiện tại không

          questionCard.innerHTML = `
              <div class="d-flex justify-content-between align-items-center flex-wrap">
                  <div class="username">
                      <i class="bi bi-person-circle"></i>
                      <span>${question.name || 'Khách'}</span>
                  </div>
                  <span class="date">${question.date}</span>
              </div>
              <div class="d-flex justify-content-between align-items-center">
                  <p class="question-title mb-0">${question.text}</p>
                  <div class="action-buttons">
                      ${isCurrentUser ? `<button class="btn btn-sm btn-outline-secondary edit-btn me-1" data-index="${start + index}">Chỉnh sửa</button>` : ''}
                      ${isCurrentUser ? `<button class="btn btn-sm btn-outline-danger delete-btn" data-index="${start + index}">Xóa</button>` : ''}
                  </div>
              </div>
              <p class="status-text">${question.answered ? 'Đã trả lời' : 'Chưa có câu trả lời'}</p>
              ${question.answered && question.answer ? `<p class="answer-text"><strong>Trả lời:</strong> ${question.answer}</p>` : ''}
          `;
          questionList.appendChild(questionCard);
      });

      // Thêm sự kiện cho các nút chỉnh sửa
      document.querySelectorAll('.edit-btn').forEach(button => {
          button.addEventListener('click', (e) => {
              const index = parseInt(e.target.getAttribute('data-index'));
              editQuestion(index);
          });
      });

      // Thêm sự kiện cho các nút xóa
      document.querySelectorAll('.delete-btn').forEach(button => {
          button.addEventListener('click', (e) => {
              const index = parseInt(e.target.getAttribute('data-index'));
              deleteQuestion(index);
          });
      });

      updatePagination(); // Cập nhật nút phân trang
  }

  // Hàm chỉnh sửa câu hỏi
  function editQuestion(index) {
      const question = questions[index];
      const newQuestionText = prompt('Chỉnh sửa câu hỏi:', question.text);
      if (newQuestionText && newQuestionText.trim()) {
          questions[index].text = newQuestionText.trim();
          displayQuestions(currentPage); // Cập nhật giao diện
      }
  }

  // Hàm xóa câu hỏi
  function deleteQuestion(index) {
      if (confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')) {
          questions.splice(index, 1); // Xóa câu hỏi khỏi mảng
          // Cập nhật trang hiện tại nếu cần
          const totalPages = Math.ceil(questions.length / itemsPerPage);
          if (currentPage > totalPages && totalPages > 0) {
              currentPage = totalPages;
          } else if (questions.length === 0) {
              currentPage = 1;
          }
          displayQuestions(currentPage); // Cập nhật giao diện
      }
  }

  // Hàm cập nhật phân trang
  function updatePagination() {
      const totalPages = Math.ceil(questions.length / itemsPerPage);
      pagination.innerHTML = ''; // Xóa nội dung phân trang hiện tại

      // Nút "Trước"
      if (currentPage > 1) {
          const prevButton = document.createElement('button');
          prevButton.className = 'btn btn-outline-primary';
          prevButton.textContent = 'Trước';
          prevButton.addEventListener('click', () => {
              currentPage--;
              displayQuestions(currentPage);
          });
          pagination.appendChild(prevButton);
      }

      // Nút "Sau"
      if (currentPage < totalPages) {
          const nextButton = document.createElement('button');
          nextButton.className = 'btn btn-outline-primary';
          nextButton.textContent = 'Sau';
          nextButton.addEventListener('click', () => {
              currentPage++;
              displayQuestions(currentPage);
          });
          pagination.appendChild(nextButton);
      }

      // Hiển thị thông tin trang
      const pageInfo = document.createElement('span');
      pageInfo.className = 'ms-2 align-self-center';
      pageInfo.textContent = `Trang ${currentPage} / ${totalPages || 1}`;
      pagination.appendChild(pageInfo);
  }

  // Xử lý gửi form
  form.addEventListener('submit', (e) => {
      e.preventDefault();

      const name = document.getElementById('question-name').value.trim();
      const questionText = document.getElementById('question-text').value.trim();

      if (name && questionText) {
          setCurrentUser(name); // Lưu tên người dùng hiện tại

          // Thêm câu hỏi mới vào mảng
          const newQuestion = {
              name: name,
              text: questionText,
              date: new Date().toLocaleString('vi-VN', {
                  month: 'short',
                  day: 'numeric',
                  hour: '2-digit',
                  minute: '2-digit'
              }),
              answered: false,
              answer: null
          };
          questions.unshift(newQuestion); // Thêm vào đầu mảng

          // Tính lại trang hiện tại để hiển thị câu hỏi mới
          currentPage = 1; // Quay về trang 1 khi có câu hỏi mới
          displayQuestions(currentPage);

          // Xóa nội dung textarea
          document.getElementById('question-text').value = '';
      } else {
          alert('Vui lòng nhập tên và câu hỏi!');
      }
  });

  // Khởi tạo: thêm một số câu hỏi mẫu
  questions = [
      {
          name: 'User1',
          text: 'Món ăn này có cay không?',
          date: 'Mar 18, 01:24',
          answered: true,
          answer: 'Không, món ăn này không cay.'
      },
      {
          name: 'User2',
          text: 'Giao hàng mất bao lâu?',
          date: 'Mar 18, 01:24',
          answered: false,
          answer: null
      },
      {
          name: 'User3',
          text: 'Có món chay không?',
          date: 'Mar 18, 01:24',
          answered: true,
          answer: 'Có, chúng tôi có nhiều món chay trong thực đơn.'
      },
      {
          name: 'User4',
          text: 'Giá món này bao nhiêu?',
          date: 'Mar 18, 01:24',
          answered: false,
          answer: null
      }
  ];

  // Hiển thị danh sách câu hỏi ban đầu
  displayQuestions(currentPage);
});