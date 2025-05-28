$(document).ready(function () {
    loadDoctorTable();

    function loadDoctorTable() {
        $.ajax({
            url: "load_doctors.php",
            type: "GET",
            success: function (data) {
                $("#doctorTable").html(data);
            }
        });
    }

    $(document).on("click", ".edit-btn", function () {
        let doctorId = $(this).data("id");

        $.ajax({
            url: "get_doctor.php",
            type: "POST",
            data: { iddoctor: doctorId },
            dataType: "json",
            success: function (data) {
                $("#edit_iddoctor").val(data.iddoctor);
                $("#edit_ndoctor").val(data.ndoctor);
                $("#edit_position").val(data.position);
                $("#edit_email").val(data.email);
                $("#edit_status").val(data.status);
                $("#editDoctorModal").modal("show");
            }
        });
    });

    $("#saveDoctor").click(function () {
        let formData = $("#editDoctorForm").serialize();

        $.ajax({
            url: "edit_doctor_ajax.php",
            type: "POST",
            data: formData,
            success: function (response) {
                if (response === "success") {
                    showToast("บันทึกข้อมูลสำเร็จ!", "success");
                    $("#editDoctorModal").modal("hide");
                    loadDoctorTable();
                } else {
                    showToast("เกิดข้อผิดพลาด: " + response, "danger");
                }
            }
        });
    });

    function showToast(message, type) {
        let toast = $("#toast");
        toast.find(".toast-body").text(message);
        toast.removeClass("bg-success bg-danger").addClass("bg-" + type);
        toast.toast("show");
    }
});
