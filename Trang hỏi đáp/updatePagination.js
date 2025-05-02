import { loadFAQs } from "./displayQuestion.js";
import { itemsPerPage, getCurrentPage, setCurrentPage } from "./config.js";

export function updatePagination(totalItems) {
    const totalPages = Math.ceil(totalItems / itemsPerPage);
    let pagination = document.querySelector('.pagination');
    if (!pagination) {
        pagination = document.createElement('div');
        pagination.className = 'pagination d-flex justify-content-center gap-2 mt-3';
        document.querySelector('.question-section').appendChild(pagination);
    }
    pagination.innerHTML = '';

    const currentPage = getCurrentPage();

    if (currentPage > 1) {
        const prevButton = document.createElement('button');
        prevButton.className = 'btn btn-outline-primary';
        prevButton.textContent = 'Trước';
        prevButton.onclick = () => {
            setCurrentPage(currentPage - 1);
            loadFAQs(currentPage - 1);
        };
        pagination.appendChild(prevButton);
    }

    if (currentPage < totalPages) {
        const nextButton = document.createElement('button');
        nextButton.className = 'btn btn-outline-primary';
        nextButton.textContent = 'Sau';
        nextButton.onclick = () => {
            setCurrentPage(currentPage + 1);
            loadFAQs(currentPage + 1);
        };
        pagination.appendChild(nextButton);
    }

    const pageInfo = document.createElement('span');
    pageInfo.className = 'ms-2 align-self-center';
    pageInfo.textContent = `Trang ${currentPage} / ${totalPages}`;
    pagination.appendChild(pageInfo);
}
