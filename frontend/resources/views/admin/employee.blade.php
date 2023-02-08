@extends('layouts.master')

@section('css')
@endsection

@section('breadcrumb')
<head>
    {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.19.2/axios.min.js"></script>
  </head>
<div class="col-sm-6">
    <h4 class="page-title text-left">Employees</h4>
    <ol class="breadcrumb">
        <li class="breadcrumb-item"><a href="javascript:void(0);">Home</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Employees</a></li>
        <li class="breadcrumb-item"><a href="javascript:void(0);">Employees List</a></li>
  
    </ol>
</div>
@endsection
{{-- @section('button')
<a href="#addnew" data-toggle="modal" class="btn btn-primary btn-sm btn-flat"><i class="mdi mdi-plus mr-2"></i>Add</a>
        

@endsection --}}

@section('content')
@include('includes.flash')


                      <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                                <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        
                                                    <thead>
                                                    <tr>
                                                        <th data-priority="1">Employee ID</th>
                                                        <th data-priority="2">Name</th>
                                                        <th data-priority="3">Attendance Report</th>
                                                        <th data-priority="4">Leave Report</th>
                                                        <th data-priority="5">Late Report</th>
                                                     
                                                    </tr>
                                                    </thead>
                                                    <tbody>
                                                        @foreach( $employees as $employee)

                                                        <tr>
                                                            <td>{{$employee->id}}</td>
                                                            <td>{{$employee->name}}</td>
                                                            
                                                            {{-- <td>{{$employee->position}}</td> --}}
                                                            <td> <button id="btn<?php echo $employee->id; ?>" value= "<?php echo $employee->id;?>  " onclick="presentRequest(<?php echo $employee->id;?>)"  > Generate </button></td>
                                                            <td> <button id="btnone<?php echo $employee->id; ?>" value= "<?php echo $employee->id;?>  " onclick="makeRequest(<?php echo $employee->id;?>)"  > Generate </button></td>
                                                            <td> <button id="btntwo<?php echo $employee->id; ?>" value= "<?php echo $employee->id;?>  " onclick="lateRequest(<?php echo $employee->id;?>)"  > Generate </button></td>
                                                            {{-- <script src="./node_modules/axios/dist/axios.min.js"></script> --}}
                                                            {{-- <script src="./node_modules/axios/dist/axios.min.js"></script> --}}

                                                            
                                                            {{-- <td>
                                                                @if(isset($employee->schedules->first()->slug))
                                                                {{$employee->schedules->first()->slug}}
                                                                @endif
                                                            </td> --}}
                                                            {{-- <script>
                                                                 let btn = document.getElementById("btn"+1);
btn.addEventListener('click', event => {
console.log(btn.value);
makeRequest(btn.value);
}); 
                                                            </script> --}}
                                                            <td>
                                                            </td>
                                                        </tr>
                                                        @endforeach
                                                   
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end col -->
                        </div> <!-- end row -->    
                                    


@endsection


@section('script')
<!-- Responsive-table-->


<script>
 
   //const { jsPDF } = require("jspdf"); 
   function createPDF() {
   

}
createPDF();
    async function makeRequest(value) {
        
        let btn = document.getElementById("btnone"+value,);
        
        // const id = $employee->id;
        console.log(btn.value);
        var id = btn.value;
        const config = {
            method: 'get',
            url: `http://127.0.0.1:8001/api/lrecords/${id}`
        }
    
        let res = await axios(config)
        for(rec in res.data.record){
            const dateTime = res.data.record[rec].created_at.split(" ");
            // console.log(dateTime[0]);
            // console.log(dateTime[1]);
            let today = new Date();
        let firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

        let differenceInMilliseconds = today - firstDayOfMonth;
        let differenceInDays = differenceInMilliseconds / 86400000;
        var absentdate= new Array();
        var date = new Date();
        var month = date.getMonth();
var year = date.getFullYear();
        for(let i=1;i<differenceInDays;i++){
            var leaveDate = new Date(year, month, i);
            absentdate.push(leaveDate);
        }
        dateTime.forEach(function(date) {
            let date1 = new Date(date);

           
            let day = date1.getDate();
            //console.log(day,"din")
            for(let i=0;i<=differenceInDays;i++){
                if(i==day){
                    console.log(i,"din"),
                    console.log(day,'day')
                    var value = absentdate[i-1];
                    console.log(value,'date')
                    let index=absentdate.indexOf(value);
                    if(index!=-1){
                        console.log(index,'somethiing happened')
                        absentdate.splice(index,1);
                    }
                    
                        
                    
                }
            }

      });

        
      console.log(absentdate,"dfgf");

          console.log(`${Math.floor(differenceInDays)} days have passed in this month.`);

            
        }
       // createPDF();
       // import { jsPDF } from "jspdf";
        // console.log(latecount); 
        
        var pdf = new jsPDF();

// Set the font size and type
mlength = absentdate.length;
var absentjoin = new Array(mlength);

for(i=0;i<absentjoin.length;i++){
    absentjoin[i]=new Array(2);
    absentjoin[i][0]=absentdate[i];
}
console.log(absentjoin,"double");
var header = ["Leave Date"];
pdf.autoTable({
  head: [header],
  body: absentjoin,
  startY: 20
});

//pdf.text(35, 50, absentdate);

// pdf.save('auto_table_with_javascript_data');
// Generate the PDF
pdf.save("generated.pdf");
    


       
      
       
    }
    makeRequest();
    async function lateRequest(value) {
        
        let btn = document.getElementById("btntwo"+value,);
        
        // const id = $employee->id;
        console.log(btn.value);
        var id = btn.value;
        const config = {
            method: 'get',
            url: `http://127.0.0.1:8001/api/lrecords/${id}`
        }
    
        let res = await axios(config)
         var latedate= new Array();
        for(rec in res.data.record){
            const dateTime = res.data.record[rec].checkin.split(":");
           
            if(dateTime[0]>=9){
                 latedate.push(res.data.record[rec].created_at);
               
            }
            
            // console.log(dateTime[1]);
          
        
       
       
        

        
     

         // console.log(`${Math.floor(differenceInDays)} days have passed in this month.`);

            
        }
         console.log(latedate,"late date");
       // createPDF();
       // import { jsPDF } from "jspdf";
        // console.log(latecount); 
        
        //var pdf = new jsPDF();

// Set the font size and type
var pdf = new jsPDF();
//     pdf.setFontSize(22);
// pdf.setFont("times");
// pdf.setFontType("bolditalic");

// Add some text to the PDF
// latedate.forEach(function(date) {
//     pdf.text(35, 25, `${date}`);
// });
console.log(latedate,"late");
mlength = latedate.length;
var doublejoin = new Array(mlength);

for(i=0;i<doublejoin.length;i++){
    doublejoin[i]=new Array(2);
    doublejoin[i][0]=latedate[i];
}
console.log(doublejoin,"double");

var header = ["Late date"];
pdf.autoTable({
  head: [header],
  body: doublejoin,
  startY: 20
});
//pdf.text(35, 50, absentdate);

// pdf.save('auto_table_with_javascript_data');
// Generate the PDF
pdf.save("generated.pdf");
    


       
      
       
    }
    lateRequest();
    async function presentRequest(value) {
        
        let btn = document.getElementById("btn"+value,);
        
        // const id = $employee->id;
        console.log(btn.value);
        var id = btn.value;
        const config = {
            method: 'get',
            url: `http://127.0.0.1:8001/api/lrecords/${id}`
        }
    
        let res = await axios(config)
        for(rec in res.data.record){
            const dateTime = res.data.record[rec].created_at.split(" ");
            // console.log(dateTime[0]);
            // console.log(dateTime[1]);
            let today = new Date();
        let firstDayOfMonth = new Date(today.getFullYear(), today.getMonth(), 1);

        let differenceInMilliseconds = today - firstDayOfMonth;
        let differenceInDays = differenceInMilliseconds / 86400000;
        var absentdate= new Array();
        var presentdate= new Array();
        var date = new Date();
        var month = date.getMonth();
var year = date.getFullYear();
        for(let i=1;i<differenceInDays;i++){
            var leaveDate = new Date(year, month, i);
            absentdate.push(leaveDate);
        }
        dateTime.forEach(function(date) {
            let date1 = new Date(date);
             
            let day = date1.getDate();
            console.log(day);
            for(let i=0;i<differenceInDays;i++){
                if(i==day){
                    presentdate.push(date);
                    let index=absentdate.indexOf(i);
                    if(index!==-1){
                        absentdate.splice(index,1);
                        
                    }
                }
            }

      });

        
      

          console.log(`${Math.floor(differenceInDays)} days have passed in this month.`);

            
        }
        console.log(absentdate,"A");
        console.log(presentdate,"P");
       // createPDF();
       // import { jsPDF } from "jspdf";
        // console.log(latecount); 
        
        var pdf = new jsPDF();

// Set the font size and type


//pdf.text(35, 50, absentdate);

// pdf.save('auto_table_with_javascript_data');
// Generate the PDF


var maxlength = 0;
if(presentdate.length>absentdate.length){
    maxlength= presentdate.length;
}else{
    maxlength = absentdate.length;
}

var joined = new Array(maxlength);
for(let i= 0;i< maxlength;i++){
    joined[i]=new Array(2);
    joined[i][0]=presentdate[i];
    joined[i][1]=absentdate[i];
}
var count = maxlength;
var count1 = maxlength;
while(maxlength<presentdate.length){
     joined[count][0]=presentdate[count];
     count++;
}
while(maxlength<absentdate.length){
     joined[count1][0]=absentdate[count1];
     count1++;
}


var header = ["Present date","Absent date"];
pdf.autoTable({
  head: [header],
  body: joined,
  startY: 20
});


pdf.save("generated.pdf");
    


       
      
       
    }
    presentRequest();
    </script>
   
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.min.js"></script>
   <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.2.11/jspdf.plugin.autotable.min.js"></script>
    


@endsection