<?php
session_start();
require_once '../include/config.php';

// Thống kê
$total_questions = 0;
$answered_questions = 0;

$stmt = $connection->prepare("SELECT COUNT(*) as total FROM question");
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $total_questions = $row['total'];
}

$stmt = $connection->prepare("SELECT COUNT(*) as answered FROM question WHERE answered = TRUE");
$stmt->execute();
$result = $stmt->get_result();
if ($row = $result->fetch_assoc()) {
    $answered_questions = $row['answered'];
}

// Lấy danh sách câu hỏi gần đây
$query = "SELECT q.ID_question, q.ID_user, q.Content, q.Created_at, q.answered, q.answer, q.answer_image, u.Username 
          FROM question q 
          JOIN user u ON q.ID_user = u.ID_user 
          ORDER BY q.Created_at DESC 
          LIMIT 5";
$stmt = $connection->prepare($query);
$stmt->execute();
$result = $stmt->get_result();
$questions = $result->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Foodiness Admin</title>
    <link rel="shortcut icon" href="./assets/compiled/svg/favicon.svg" type="image/x-icon">
    <link rel="stylesheet" href="./assets/compiled/css/app.css">
    <link rel="stylesheet" href="./assets/compiled/css/app-dark.css">
    <link rel="stylesheet" href="./assets/compiled/css/iconly.css">
    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
</head>

<body>
    <script src="assets/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="index.php"><img src="./assets/compiled/svg/logo.svg" alt="Logo" srcset=""></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2 align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--system-uicons" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2" opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24">
                                <path fill="currentColor" d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z"></path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <li class="sidebar-title">Menu</li>
                        <li class="sidebar-item active">
                            <a href="index.php" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="manage_questions.php" class='sidebar-link'>
                                <i class="bi bi-question-circle-fill"></i>
                                <span>Quản lý câu hỏi</span>
                            </a>
                        </li>
                        <li class="sidebar-item">
                            <a href="../auth/login.php" class='sidebar-link'>
                                <i class="bi bi-box-arrow-right"></i>
                                <span>Đăng xuất</span>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>
            <div class="page-heading">
                <h3>Dashboard - Quản lý Foodiness</h3>
            </div>
            <div class="page-content">
                <section class="row">
                    <div class="col-12 col-lg-9">
                        <div class="row">
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon purple mb-2">
                                                    <i class="bi bi-question-circle-fill"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Tổng câu hỏi</h6>
                                                <h6 class="font-extrabold mb-0"><?php echo $total_questions; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 col-lg-3 col-md-6">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start">
                                                <div class="stats-icon green mb-2">
                                                    <i class="bi bi-check-circle-fill"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Đã trả lời</h6>
                                                <h6 class="font-extrabold mb-0"><?php echo $answered_questions; ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Thống kê câu hỏi</h4>
                                    </div>
                                    <div class="card-body">
                                        <div id="chart-profile-visit"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Câu hỏi gần đây</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="table-responsive">
                                            <table class="table table-hover table-lg">
                                                <thead>
                                                    <tr>
                                                        <th>ID</th>
                                                        <th>Người hỏi</th>
                                                        <th>Câu hỏi</th>
                                                        <th>Ngày tạo</th>
                                                        <th>Trạng thái</th>
                                                        <th>Hành động</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <?php foreach ($questions as $question): ?>
                                                        <tr>
                                                            <td><?php echo htmlspecialchars($question['ID_question']); ?></td>
                                                            <td><?php echo htmlspecialchars($question['Username']); ?></td>
                                                            <td><?php echo htmlspecialchars($question['Content']); ?></td>
                                                            <td><?php echo htmlspecialchars($question['Created_at']); ?></td>
                                                            <td class="<?php echo $question['answered'] ? 'text-success' : 'text-warning'; ?>">
                                                                <?php echo $question['answered'] ? '<i class="bi bi-check-circle-fill"></i> Đã trả lời' : '<i class="bi bi-exclamation-circle-fill"></i> Chưa trả lời'; ?>
                                                            </td>
                                                            <td>
                                                                <?php if (!$question['answered']): ?>
                                                                    <button class="btn btn-sm btn-primary answer-btn" data-id="<?php echo $question['ID_question']; ?>"><i class="bi bi-pen-fill"></i> Trả lời</button>
                                                                <?php endif; ?>
                                                                <button class="btn btn-sm btn-danger delete-btn" data-id="<?php echo $question['ID_question']; ?>"><i class="bi bi-trash-fill"></i> Xóa</button>
                                                            </td>
                                                        </tr>
                                                    <?php endforeach; ?>
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-lg-3">
                        <div class="card">
                            <div class="card-body py-4 px-4">
                                <div class="d-flex align-items-center">
                                    <div class="avatar avatar-xl">
                                        <img src="./assets/compiled/jpg/1.jpg" alt="Admin">
                                    </div>
                                    <div class="ms-3 name">
                                        <h5 class="font-bold">Quản trị viên</h5>
                                        <h6 class="text-muted mb-0">Foodiness Admin</h6>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-header">
                                <h4>Thông tin hệ thống</h4>
                            </div>
                            <div class="card-body">
                                <p><strong>Phiên bản:</strong> 1.0.0</p>
                                <p><strong>Ngày cập nhật:</strong> 04/05/2025</p>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>2025 © Foodiness</p>
                    </div>
                    <div class="float-end">
                        <p>Crafted with <span class="text-danger"><i class="bi bi-heart-fill icon-mid"></i></span> by xAI</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    <script src="assets/static/js/components/dark.js"></script>
    <script src="assets/extensions/perfect-scrollbar/perfect-scrollbar.min.js"></script>
    <script src="assets/compiled/js/app.js"></script>
    <script src="assets/extensions/apexcharts/apexcharts.min.js"></script>
    <script>
        var options = {
            series: [{
                name: 'Tổng câu hỏi',
                data: [<?php echo $total_questions; ?>]
            }, {
                name: 'Đã trả lời',
                data: [<?php echo $answered_questions; ?>]
            }, {
                name: 'Chưa trả lời',
                data: [<?php echo $total_questions - $answered_questions; ?>]
            }],
            chart: {
                height: 350,
                type: 'bar',
                toolbar: {
                    show: false
                }
            },
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                }
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 2,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Số lượng'],
            },
            yaxis: {
                title: {
                    text: 'Số câu hỏi'
                }
            },
            fill: {
                opacity: 1
            },
            colors: ['#4e73df', '#1cc88a', '#f6c23e'],
            tooltip: {
                y: {
                    formatter: function (val) {
                        return val + " câu hỏi"
                    }
                }
            }
        };

        var chart = new ApexCharts(document.querySelector("#chart-profile-visit"), options);
        chart.render();

        document.addEventListener('DOMContentLoaded', () => {
            const answerForm = document.createElement('form');
            answerForm.id = 'answer-question-form';
            answerForm.enctype = 'multipart/form-data';
            answerForm.innerHTML = `
                <div class="modal fade" id="answerQuestionModal" tabindex="-1" aria-labelledby="answerQuestionModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="answerQuestionModalLabel">Trả lời câu hỏi</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input type="hidden" id="answer-question-id" name="id">
                                <div class="mb-3">
                                    <label for="answer-text" class="form-label">Câu trả lời</label>
                                    <textarea class="form-control" id="answer-text" name="answer" rows="3" required></textarea>
                                    <div class="invalid-feedback">Vui lòng nhập câu trả lời!</div>
                                </div>
                                <div class="mb-3">
                                    <label for="answer-image" class="form-label">Hình ảnh minh họa (tùy chọn)</label>
                                    <input type="file" class="form-control" id="answer-image" name="answer_image" accept="image/*">
                                    <div class="invalid-feedback">Vui lòng chọn file hình ảnh hợp lệ (JPG, PNG, GIF)!</div>
                                </div>
                                <button type="submit" class="btn btn-primary">Gửi câu trả lời</button>
                            </div>
                        </div>
                    </div>
                </div>
            `;
            document.body.appendChild(answerForm);

            document.querySelectorAll('.answer-btn').forEach(button => {
                button.addEventListener('click', () => {
                    const id = button.getAttribute('data-id');
                    document.getElementById('answer-question-id').value = id;
                    new bootstrap.Modal(document.getElementById('answerQuestionModal')).show();
                });
            });

            answerForm.addEventListener('submit', (e) => {
                e.preventDefault();
                let isValid = true;
                const answerText = document.getElementById('answer-text');
                const answerImage = document.getElementById('answer-image');

                if (!answerText.value.trim()) {
                    answerText.classList.add('is-invalid');
                    isValid = false;
                } else {
                    answerText.classList.remove('is-invalid');
                }

                const allowedTypes = ['image/jpeg', 'image/png', 'image/gif'];
                if (answerImage.files.length > 0) {
                    const file = answerImage.files[0];
                    if (!allowedTypes.includes(file.type)) {
                        answerImage.classList.add('is-invalid');
                        isValid = false;
                    } else if (file.size > 2 * 1024 * 1024) {
                        answerImage.classList.add('is-invalid');
                        answerImage.nextElementSibling.textContent = 'Hình ảnh không được lớn hơn 2MB!';
                        isValid = false;
                    } else {
                        answerImage.classList.remove('is-invalid');
                    }
                }

                if (!isValid) return;

                const formData = new FormData(answerForm);
                fetch('answer_question.php', {
                    method: 'POST',
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert(data.message);
                        location.reload();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => console.error('Lỗi khi trả lời:', error));
            });

            document.querySelectorAll('.delete-btn').forEach(button => {
                button.addEventListener('click', () => {
                    if (confirm('Bạn có chắc chắn muốn xóa câu hỏi này?')) {
                        const id = button.getAttribute('data-id');
                        fetch(`../Trang_hoi_dap/delete_question.php?id=${id}`, {
                            method: 'GET'
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert(data.message);
                                location.reload();
                            } else {
                                alert(data.message);
                            }
                        })
                        .catch(error => console.error('Lỗi khi xóa:', error));
                    }
                });
            });
        });
    </script>
</body>

</html>