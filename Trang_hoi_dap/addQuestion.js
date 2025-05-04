document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('question-form');
    const questionList = document.getElementById('question-list');
    const pagination = document.getElementById('pagination');
    const currentUserInput = document.getElementById('current-user');

    // Cấu hình phân trang
    const itemsPerPage = 4; // Số câu hỏi mỗi trang
    let currentPage = 1; // Trang hiện tại
    let questions = []; // Mảng lưu trữ tất cả câu hỏi
    let currentUser = currentUserInput.value; // Lấy username từ input

    // Lấy dữ liệu từ server khi tải trang
    function loadQuestions() {
        fetch('getQuestion.php')
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    questions = data.questions || [];
                    displayQuestions(currentPage);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Lỗi khi lấy câu hỏi:', error));
    }

    // Lưu câu hỏi mới vào server
    function saveQuestion(questionText) {
        const formData = new FormData();
        formData.append('question_text', questionText);

        fetch('saveQuestion.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(data.message);
                loadQuestions(); // Tải lại danh sách câu hỏi ngay sau khi gửi
            } else {
                alert(data.message);
            }
        })
        .catch(error => console.error('Lỗi khi gửi câu hỏi:', error));
    }

    // Hàm hiển thị danh sách câu hỏi theo trang
    function displayQuestions(page) {
        questionList.innerHTML = '';
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
            const isCurrentUser = question.name === currentUser;

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

        document.querySelectorAll('.edit-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const index = parseInt(e.target.getAttribute('data-index'));
                editQuestion(index);
            });
        });

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', (e) => {
                const index = parseInt(e.target.getAttribute('data-index'));
                deleteQuestion(index);
            });
        });

        updatePagination();
    }

    // Hàm chỉnh sửa câu hỏi
    function editQuestion(index) {
        const question = questions[index];
        const newQuestionText = prompt('Chỉnh sửa câu hỏi:', question.text);
        if (newQuestionText && newQuestionText.trim()) {
            const formData = new FormData();
            formData.append('question_id', question.id);
            formData.append('question_text', newQuestionText);

            fetch('updateQuestion.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    questions[index].text = newQuestionText.trim();
                    displayQuestions(currentPage);
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Lỗi khi chỉnh sửa:', error));
        }
    }

    // Hàm xóa câu hỏi
    function deleteQuestion(index) {
        if (confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')) {
            const questionId = questions[index].id;

            fetch(`deleteQuestion.php?id=${questionId}`, {
                method: 'GET'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    questions.splice(index, 1);
                    const totalPages = Math.ceil(questions.length / itemsPerPage);
                    if (currentPage > totalPages && totalPages > 0) {
                        currentPage = totalPages;
                    } else if (questions.length === 0) {
                        currentPage = 1;
                    }
                    displayQuestions(currentPage);
                    alert(data.message);
                } else {
                    alert(data.message);
                }
            })
            .catch(error => console.error('Lỗi khi xóa:', error));
        }
    }

    // Hàm cập nhật phân trang
    function updatePagination() {
        const totalPages = Math.ceil(questions.length / itemsPerPage);
        pagination.innerHTML = '';

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
            saveQuestion(questionText);
            document.getElementById('question-text').value = '';
        } else {
            alert('Vui lòng nhập câu hỏi!');
        }
    });

    // Khởi tạo: Lấy dữ liệu từ server và hiển thị
    loadQuestions();
});