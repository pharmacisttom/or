<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Search ค้นหาผู้ป่วย</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Live Search ค้นหาผู้ป่วย</h2>
        <input type="text" id="searchInput" class="form-control" placeholder="ค้นหาโดย AN หรือ HN...">

        <table class="table table-bordered table-striped mt-3">
            <thead class="table-dark">
                <tr>
                    <th>HN</th>
                    <th>AN</th>
                    <th>ชื่อ-สกุล</th>
                    <th>อายุ</th>
                    <th>น้ำหนัก</th>
                    <th>ส่วนสูง</th>
                    <th>หมายเลขบัตร ปชช.</th>
                    <th>อาการแสดง</th>
                    <th>นำเข้าข้อมูลในระบบ</th>
                </tr>
            </thead>
            <tbody id="resultTable"></tbody>
        </table>
    </div>

    <script>
        $(document).ready(function(){
            $("#searchInput").on("keyup", function(){
                let query = $(this).val();
                if(query.length > 1){
                    $.ajax({
                        url: "search_patientipd.php",
                        method: "GET",
                        data: { query: query },
                        dataType: "json",
                        success: function(data){
                            let output = "";
                            if(data.length > 0){
                                data.forEach(patient => {
                                    output += `<tr>
                                        <td>${patient.hn}</td>
                                        <td>${patient.an}</td>
                                        <td>${patient.fullname}</td>
                                        <td>${patient.yage}</td>
                                        <td>${patient.weight}</td>
                                        <td>${patient.high}</td>
                                        <td>${patient.cardid}</td>
                                        <td>${patient.sign}</td>
                                        <td>
                                            <button class="btn btn-success import-btn" data-an="${patient.an}">นำเข้าข้อมูล</button>
                                        </td>
                                    </tr>`;
                                });
                            } else {
                                output = `<tr><td colspan="9" class="text-center text-danger">ไม่พบข้อมูล</td></tr>`;
                            }
                            $("#resultTable").html(output);
                        }
                    });
                } else {
                    $("#resultTable").html("");
                }
            });

            // ฟังก์ชันกดปุ่มเพื่อบันทึกข้อมูลไปยัง `adtooripd.php`
            $(document).on("click", ".import-btn", function(){
                let an = $(this).data("an");

                $.ajax({
                    url: "adtooripd.php",
                    method: "POST",
                    data: { an: an },
                    dataType: "json",
                    success: function(response){
                    alert(response.message);
            if (response.status === "success" && response.redirect) {
                window.location.href = response.redirect; // ไปที่ pt.php
            }
                    }
                });
            });
        });
    </script>
</body>
</html>



