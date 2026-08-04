// script.js
$(document).ready(function () {
  $.ajax({
    url: "index.php?action=my-task", // <-- Route ke method getPimpinan
    type: "GET",
    dataType: "json",
    success: function (response) {
      $("#board-task").html("");
      if (response.status === "success") {
        let projectHtml = "";
        $.each(response.data, function (index, project) {
          projectHtml += `
            <div class="board-column">
                <div class="column-header bg-header-todo">
                    <span>${project.project_name}</span>
                    <span class="badge bg-white text-primary rounded-pill fw-bold">2</span>
                    <a href="https://kanboard.madinapay.id/?controller=BoardViewController&action=show&project_id=${project.project_id}" class="badge bg-primary text-light fw-bold rounded-pill fw-bold" target="_blank"><i class="bi bi-plus-lg"></i></a>
                </div>
                <div class="column-body">
          `;

          $.each(project.tasks, function (index, task) {
            projectHtml += `
              <div class="task-card">
                  <span class="badge badge-custom badge-high mb-2">To Do</span>
                  <p class="fw-semibold text-dark mb-1">${task.title}</p>
                  <p class="text-secondary small mb-3 text-break">${task.description}</p>
                  <div class="d-flex align-items-center justify-content-between border-top pt-2">
                      <small class="text-muted"><i class="bi bi-clock me-1"></i>${task.date_modification}</small>
                      <div class="d-flex gap-1">
                          <a href="https://kanboard.madinapay.id/?controller=BoardViewController&action=show&project_id=${project.project_id}" class="btn btn-sm btn-light text-primary p-1 px-2" title="Edit" target="_blank">
                              <i class="bi bi-pencil-square"></i>
                          </a>
                      </div>
                  </div>
              </div>
            `;
          });

          projectHtml += `
                </div>
            </div>
          `;
        });

        $("#board-task").html(projectHtml);
      }
    },
    error: function (xhr, status, error) {
      console.error("Gagal mengambil data:", error);
    },
  });
  // // 1. Fungsi Ambil Data (GET)
  // function loadDataPimpinan() {

  // }

  // // Jalankan fungsi load data saat halaman dibuka
  // loadDataPimpinan();

  // // 2. Fungsi Submit Form Data (POST)
  // $("#form-pimpinan").on("submit", function (e) {
  //   e.preventDefault();

  //   $.ajax({
  //     url: "index.php?action=simpanPimpinan", // <-- Route ke method simpanPimpinan
  //     type: "POST",
  //     data: $(this).serialize(),
  //     dataType: "json",
  //     success: function (response) {
  //       if (response.status === "success") {
  //         alert(response.message);
  //         $("#form-pimpinan")[0].reset();
  //         loadDataPimpinan(); // Reload list data tanpa refresh halaman
  //       } else {
  //         alert("Gagal: " + response.message);
  //       }
  //     },
  //   });
  // });
});
