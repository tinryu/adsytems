<script src="<?=$dir_js?>/js/question.js"></script>

<div ng-controller = "questionController" class="table-responsive">
    <ol class="breadcrumb">
        <li><a href="<?= base_url('question') ?>" class="active"><i class="fa fa-th-list"></i> Danh sách</a></li>
        <li><a href=""><i class="fa fa-trash-o"></i> Thùng rác</a></li>
        <li><a href="<?= base_url('question/add')?>"><i class="fa fa-edit"></i> Thêm</a></li>
    </ol>
    <div class="panel panel-default panel_toggle ">
        <div class="panel-heading">
            <h3 class="panel-title">Công cụ tìm kiếm</h3>
        </div>
        <div class="panel-body">
            <div class="box_search">
                <form action="" method="post" name="form_search" id="form_search">
                    <div class="row">
                        <div class="col-md-3">
                            <label for="group">Nhóm</label>
                            <?=$categoris;?>
                        </div>
                        <div class="col-md-3">
                            <label for="group">Ngày bắt đầu</label>
                            <input type="text" name="date_begin" class="form-control date_form">
                        </div>
                        <div class="col-md-3">
                            <label for="group">Ngày kết thúc</label>
                            <input type="text" name="date_end" class="form-control date_form">
                        </div>
                        <div class="col-md-3">
                            <label for="keyword">Từ khóa</label>
                            <input type="text" name="keyword" class="form-control">
                        </div>
                        <div class="col-md-12" style="margin-top: 10px">
                            <button class="btn btn-default" type="submit" style="width: 100%">Tìm</button>
                        </div>
                    </div>
                </form>
                <div class="clear"></div>
            </div>
        </div>
    </div>
    <table class="table table-bordered table-hover table-striped table_row" id="datatable_ajax" ng-init="init_List()">
        <thead>
            <tr>
                <th class="header" width="3%"><input id="checkall" class="checkbox" type="checkbox" name="checkall" value="all"/></th>
                <th class="header" width="5%">ID</th>
                <th class="header" width="10%">Thứ tự</th>
                <th class="header" width="">Tiêu đề</th>
                <th class="header" width="10%">Hình ảnh</th>
                <th class="header" width="25%">Thông tin</th>
                <th class="header" width="10%">Thao tác</th>
            </tr>
        </thead>
        <tbody>
            <tr ng-repeat = "question in questions" on-finish-render id="question_{{::question.id}}">
                <td align="center"><input class="checkbox" type="checkbox" value="{{::question.id}}" name="selected_id[]"></td>
                <td align="center">{{::question.id}}</td>
                <td align="center"><input type="text" class="stt" name="stt" size="4" style="text-align: center"></td>
                <td align="center">{{::question.title}}</td>
                <td align="center"><img src="{{::question.picture}}" alt="{{::question.title}}"></td>
                <td align="left">
                    Ẩn/Hiện: <input type="checkbox"> </br>
                    Ngày tạo: {{::question.date_create}} </br>
                    Ngày update: {{::question.date_update}} </br>
                </td>
                <td align="center">
                    <a href="<?= base_url();?>question/edit/{{::question.id}}" class="iframe-50x btn btn-primary"><i class="fa fa-pencil-square"></i></a>
                    <a href="javascript:;" ng-click="del_Item(question.id)" class="btn btn-danger"><i class="fa fa-trash-o"></i></a>
                </td>
             </tr>
        </tbody>
    </table>
</div>
<script>var data = <?=$data?>;</script>