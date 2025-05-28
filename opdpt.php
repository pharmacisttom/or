<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ค้นหาผู้ป่วย</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
<div class="container mt-5">
    <h2 class="text-center">ค้นหาผู้ป่วย</h2>
    
    <div class="input-group mb-3">
        <input type="text" id="search" class="form-control" placeholder="ค้นหาด้วยชื่อ, หมายเลขบัตร, หรือรหัสผู้ป่วย">
    </div>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>รหัสผู้ป่วย</th>
                <th>ชื่อ</th>
                <th>หมายเลขบัตร</th>
                <th>วันที่เข้ารับบริการ</th>
                <th>ดูข้อมูลเพิ่มเติม</th>
            </tr>
        </thead>
        <tbody id="patientTable"></tbody>
    </table>
</div>

<script>
$(document).ready(function() {
    $("#search").on("keyup", function() {
        let searchValue = $(this).val();
        if (searchValue.length > 1) { // ค้นหาเมื่อพิมพ์มากกว่า 1 ตัวอักษร
            $.ajax({
                url: "search_patient.php",
                method: "GET",
                data: { search: searchValue },
                dataType: "json",
                success: function(data) {
                    let rows = "";
                    if (data.length > 0) {
                        data.forEach(function(patient) {
                            rows += `<tr>
                                <td>${patient.hn}</td>
                                <td>${patient.fullname}</td>
                                <td>${patient.cardid}</td>
                                <td>${patient.regdate}</td>
                                <td><a href="patient_detail.php?hn=${patient.hn}" class="btn btn-info btn-sm">ดูข้อมูล</a></td>
                            </tr>`;
                        });
                    } else {
                        rows = `<tr><td colspan="5" class="text-center text-danger">ไม่พบข้อมูลผู้ป่วย</td></tr>`;
                    }
                    $("#patientTable").html(rows);
                }
            });
        } else {
            $("#patientTable").html(""); // เคลียร์ตารางถ้าพิมพ์น้อยกว่า 2 ตัวอักษร
        }
    });
});
</script>

</body>
</html>
