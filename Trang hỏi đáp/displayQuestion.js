import { updatePagination } from "./updatePagination.js";
import { itemsPerPage, setCurrentPage, getCurrentPage } from "./config.js";

// Hiển thị danh sách câu hỏi
function displayFAQs(faqs, page, totalItems) {
    const questionSection = document.querySelector('.question-section');
    const existingCards = questionSection.querySelectorAll('.question-card');
    existingCards.forEach(card => card.remove());

    faqs.forEach(faq => {
        const questionCard = document.createElement('div');
        questionCard.className = 'question-card animate__animated animate__fadeIn';
        questionCard.innerHTML = `
            <div class="d-flex justify-content-between align-items-center flex-wrap">
                <div class="username">
                    <i class="bi bi-person-circle"></i>
                    <span>${faq.name || 'Khách'}</span>
                </div>
                <span class="date">${formatDate(faq.Date_create)}</span>
            </div>
            <p class="question-title">${faq.question}</p>
            <p>${faq.answer ? `Trả lời: ${faq.answer}` : 'Chưa có câu trả lời'}</p>
        `;
        questionSection.appendChild(questionCard);
    });

    updatePagination(totalItems);
}

// Format ngày
function formatDate(dateStr) {
    const date = new Date(dateStr);
    return isNaN(date.getTime()) ? 'Không xác định' : date.toLocaleString('vi-VN', {
        month: 'short', day: 'numeric', year: 'numeric'
    });
}

// Thêm câu hỏi mới vào DOM
function addNewQuestionToDOM(name, question) {
    const questionSection = document.querySelector('.question-section');
    const questionCard = document.createElement('div');
    questionCard.className = 'question-card animate__animated animate__fadeIn';
    questionCard.innerHTML = `
        <div class="d-flex justify-content-between align-items-center flex-wrap">
            <div class="username">
                <i class="bi bi-person-circle"></i>
                <span>${name || 'Khách'}</span>
            </div>
            <span class="date">${formatDate(new Date())}</span>
        </div>
        <p class="question-title">${question}</p>
        <p>Chưa có câu trả lời</p>
    `;
    // Thêm câu hỏi mới vào đầu danh sách
    const firstCard = questionSection.querySelector('.question-card');
    if (firstCard) {
        questionSection.insertBefore(questionCard, firstCard);
    } else {
        questionSection.appendChild(questionCard);
    }
}

// Tải câu hỏi từ server
export async function loadFAQs(page = 1) {
    try {
        setCurrentPage(page);
        const response = await fetch(`get_faqs.php?page=${page}`);
        const data = await response.json();
        displayFAQs(data.faqs, page, data.totalItems);
    } catch (error) {
        console.error('Lỗi khi tải câu hỏi:', error);
        alert('Không thể tải danh sách câu hỏi.');
    }
}

// Khởi tạo khi trang sẵn sàng
document.addEventListener('DOMContentLoaded', () => {
    // Tải Animate.css
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css';
    document.head.appendChild(link);

    // Tải danh sách câu hỏi ban đầu
    loadFAQs(getCurrentPage());

    // Xử lý gửi form
    const form = document.querySelector('#question-form');
    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const name = formData.get('name');
        const question = formData.get('question');

        try {
            const response = await fetch('submit.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.success) {
                alert('Gửi câu hỏi thành công!');
                addNewQuestionToDOM(name, question); // Thêm câu hỏi mới vào DOM
                form.reset(); // Xóa nội dung form
                // Cập nhật phân trang (tăng totalItems lên 1)
                updatePagination(getCurrentPage() * itemsPerPage + 1);
            } else {
                alert(result.message || 'Gửi thất bại!');
            }
        } catch (err) {
            alert('Lỗi kết nối máy chủ!');
            console.error(err);
        }
    });
});