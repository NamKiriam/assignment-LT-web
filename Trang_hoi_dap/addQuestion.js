document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('question-form');
    const questionList = document.getElementById('question-list');
    const pagination = document.getElementById('pagination');
    const currentUserInput = document.getElementById('current-user');

    // Cấu hình phân trang
    const itemsPerPage = 4; // Số câu hỏi mỗi trang
    let currentPage = 1; // Trang hiện tại
    let questions = []; // Mảng lưu trữ tất cả câu hỏi
    let currentUser = currentUserInput.value; // Lấy username từ input (được thiết lập bởi $_SESSION['user_name'])

    // Đồng bộ currentUser với localStorage
    localStorage.setItem('currentUser', currentUser);

    // Lấy dữ liệu từ localStorage khi tải trang
    function loadQuestions() {
        const savedQuestions = localStorage.getItem('questions');
        if (savedQuestions) {
            questions = JSON.parse(savedQuestions).filter(q => q.name === currentUser); // Chỉ lấy câu hỏi của người dùng hiện tại
        }
    }

    // Lưu dữ liệu vào localStorage
    function saveQuestions() {
        // Lấy tất cả câu hỏi hiện có trong localStorage
        let allQuestions = JSON.parse(localStorage.getItem('questions')) || [];
        // Lọc bỏ câu hỏi của người dùng hiện tại để tránh trùng lặp
        allQuestions = allQuestions.filter(q => q.name !== currentUser);
        // Thêm câu hỏi mới của người dùng hiện tại
        allQuestions.push(...questions);
        localStorage.setItem('questions', JSON.stringify(allQuestions));
    }

    // Hàm hiển thị danh sách câu hỏi theo trang
    function displayQuestions(page) {
        questionList.innerHTML = ''; // Xóa danh sách hiện tại
        const start = (page - 1) * itemsPerPage;
        const end = start + itemsPerPage;
        const paginatedQuestions = questions.slice(start, end);

        if (paginatedQuestions.length === 0) {
            questionList.innerHTML = '<p class="text-center text-muted">Bạn chưa có câu hỏi nào.</p>';
            pagination.innerHTML = '';
            return;
        }

        paginatedQuestions.forEach((question, index) => {
            const questionCard = document.createElement('div');
            questionCard.className = 'question-card';
            const isCurrentUser = question.name === currentUser; // Luôn đúng vì chỉ hiển thị câu hỏi của người dùng

            questionCard.innerHTML = `
                <div class="d-flex justify-content-between align-items-center flex-wrap">
                    <div class="username">
                        <i class="bi bi-person-circle"></i>
                        <span>${question.name}</span>
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
            saveQuestions(); // Lưu thay đổi vào localStorage
            displayQuestions(currentPage); // Cập nhật giao diện
        }
    }

    // Hàm xóa câu hỏi
    function deleteQuestion(index) {
        if (confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')) {
            questions.splice(index, 1); // Xóa câu hỏi khỏi mảng
            saveQuestions(); // Lưu thay đổi vào localStorage
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

        const questionText = document.getElementById('question-text').value.trim();

        if (questionText) {
            // Thêm câu hỏi mới vào mảng
            const newQuestion = {
                name: currentUser,
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
            saveQuestions(); // Lưu vào localStorage
            currentPage = 1; // Quay về trang 1 khi có câu hỏi mới
            displayQuestions(currentPage); // Hiển thị lại danh sách

            // Xóa nội dung textarea
            document.getElementById('question-text').value = '';
        } else {
            alert('Vui lòng nhập câu hỏi!');
        }
    });

    // Khởi tạo: Lấy dữ liệu từ localStorage và hiển thị
    loadQuestions();
    displayQuestions(currentPage);
});