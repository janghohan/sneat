<?php
include '../dbConnect.php';

$editType = $_POST['editType'];

if($editType=='basic'){
    
    $companyIx = $_POST['companyIx'];
    $companyName = $_POST['companyName'];
    $companyAddress = $_POST['companyAddress'];
    $companyManager = $_POST['companyManager'];
    $managerContact = $_POST['managerContact'];
    $companyContact = $_POST['companyContact'];
    $companyFax = $_POST['companyFax'];
    $companySite = $_POST['companySite'];

    $sql = "UPDATE company_list SET company_name='$companyName',company_address='$companyAddress',company_manager='$companyManager',manager_contact='$managerContact',company_contact='$companyContact',company_fax='$companyFax',company_site='$companySite' WHERE ix='$companyIx'";

    if($conn->query($sql) === TRUE){
        echo '<script>alert("수정 완료"); location.href="../company-list.html";</script>';
        
    }else{
        
    }
}else if($editType=='memo'){
    $companyMemo = $_POST['companyMemo'];
    $companyIx = $_POST['companyIx'];

    $sql = "UPDATE company_list SET company_memo='$companyMemo' WHERE ix='$companyIx'";

    if($conn->query($sql) === TRUE){
        echo '<script>alert("수정 완료"); location.href="../company-list.html";</script>';
        
    }

}else if($editType=='important'){
    $companyImportant = $_POST['companyImportant'];
    $companyIx = $_POST['companyIx'];

    $sql = "UPDATE company_list SET company_important='$companyImportant' WHERE ix='$companyIx'";

    if($conn->query($sql) === TRUE){
        echo '<script>alert("수정 완료"); location.href="../company-list.html";</script>';
        
    }

    
}


?>