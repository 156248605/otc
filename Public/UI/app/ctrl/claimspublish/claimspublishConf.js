/**
 * Created by Administrator on 2015/12/7 0007.
 * operationButtons : 操作按钮的定义
 * searchFileds     : 查询字段的定义
 * listOperationButtons : 条目操作按钮的定义
 */
Ext.define('ui.ctrl.claimspublish.claimspublishConf',{
    extend: 'ui.extend.baseClass.baseConf',
    modelName : "债权发布",
    topicalName : '债权发布',
    modelCode : 'claimspublish',
    groupCode : '',

    infoIconCls : {view:'',edti:'',add:''},
    init : function(){
        this.callParent(arguments);
    },

    constructor: function(){
        var me = this;
        this.callParent(arguments);

        this.urlslist = this.urlslist || {};
        this.$extendConfigJson('urlslist', this._urls);
        //模块的操作按钮
        this.$extendConfigArr('operationButtons',this._opButtons);
        //查询条件field设置
        this.$extendConfigArr('searchFileds',this._scFields);
        //条目操作按钮的定义
        this.$extendConfigArr('listOperationButtons',this._lstOpButtons);

        this.$extendConfigJson('infoPanelButtons',this._infoPanelButtons);
        //
        var param = arguments[0];
        var ret = param || {};
        Ext.apply(ret,this.getDefaultWinSize());
        Ext.apply(this,ret);
    },

    _urls : {
        'get.claimspublish.list' : { url : "claims/getClaimsReleaseList" , 'pmsCode' : 'get.claimspublish.list' , checkpms : 0 },
        'get.claimspublish.view' : { url : "claims/getClaimsinfo" , 'pmsCode' : 'get.claimspublish.info' , checkpms : 0 },
        'get.claimspublish.edit' : { url : "claims/saveClaims" , 'pmsCode' : 'set.claimspublish.info' , checkpms : 0 },
        'set.claimspublish.publish' : { url : "claims/releaseClaims" , 'pmsCode' : 'set.claimspublish.publish' , checkpms : 0 },
        'set.claimspublish.claimSendBack' : { url : "claims/claimSendBack" , 'pmsCode' : 'set.claimspublish.claimSendBack' , checkpms : 0 }
    },
    _opButtons : [
        // { text : '新建+' , pmsCode : 'claimspublish.add' ,recKey : ['id']  , checkpms:0 }
        // { text : '批量删除-' , pmsCode : 'claimspublish.disable' ,recKey : ['id']  , checkpms:0 }
    ],
    _lstOpButtons : [
        { text : '查看' , pmsCode : 'claimspublish.view' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1, iconCls : ''},
        { text : '发布' , pmsCode : 'claimspublish.publish' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''},
        { text : '退回' , pmsCode : 'claimspublish.back' , recKey : ['id']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
        // { text : '退回' , pmsCode : 'claimspublish.reject' , recKey : ['id','status']/*所需record之关键字列表*/  , checkpms:1 ,iconCls : ''}
    ],
    _scFields : [
        // {fieldLabel : '产品状态' ,labelWidth : 70, name : 'cod_cf_status' , fieldtype : 'Ext.form.field.ComboBox', pmsCode:'' , checkpms:0,
        //     displayField    : 'statusname',
        //     valueField  : "status",
        //     store : Ext.create('Ext.data.ArrayStore',{
        //         fields  :   ['status', 'statusname'],
        //         data : [['1','待审核'],['2','待发布'],['3','已发布']]
        //     })
        // },
        // {fieldLabel : '债权状态' ,labelWidth : 70, name : 'title' , fieldtype : 'Ext.form.field.ComboBox', pmsCode:'' , checkpms:0,
        //     displayField    : 'statusname',
        //     valueField  : "status",
        //     store : Ext.create('Ext.data.ArrayStore',{
        //         fields  :   ['status', 'statusname'],
        //         data : [['0','不限'],['1','销售中'],['2','待销售'],['3','已售罄'],['4','已下架'],['5','待审核'],['6','待发布']]
        //     })
        // },
        // {fieldLabel : '产品类型' ,labelWidth : 70, name : 'title' , fieldtype : 'Ext.form.field.ComboBox', pmsCode:'' , checkpms:0,
        //     displayField    : 'statusname',
        //     valueField  : "status",
        //     store : Ext.create('Ext.data.ArrayStore',{
        //         fields  :   ['status', 'statusname'],
        //         data : [['0','不限'],['1','泰盛'],['2','泰丰'],['3','安享'],['4','安盈']]
        //     })
        // },
        {fieldLabel : '录入时间' ,labelWidth : 80, editable:false,name : 'dat_create' , fieldtype : 'Ext.form.field.ComboBox',displayField    : 'display', valueField     : "value", value : 0,
            store : new Ext.data.ArrayStore({
                fields  :   ['value', 'display'],
                data    :   [[0,'不限'],[1,'1周内'],[2,'1个月内'],[3,'3个月内'],[4,'3个月以上']]
            }), pmsCode:'' , checkpms:0   },
       /* {fieldLabel : '起始时间' ,labelWidth : 70, name : 'startdate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },
        {fieldLabel : '-' ,labelWidth : 20, name : 'enddate' , fieldtype : 'Ext.form.field.Date', pmsCode:'' , checkpms:0   },*/

        {fieldLabel : '关键字' ,labelWidth : 50, name : 'keyword' , fieldtype : 'Ext.form.field.Text', pmsCode:'' , checkpms:0 , emptyText : '（债权名称）'   },
        {fieldLabel : '查询' ,text : '查询' ,iconCls : '', fieldtype : 'Ext.button.Button'  , submitBtn : true , clickFn : '$search', pmsCode:'' , checkpms:0 }
    ],

    /*
    * 配置信息面板里的按钮，并制定事件后缀： fnName
    * */
    _infoPanelButtons : {
        'all' : [],
        'view' : [],
        'edit' : [{text : '保存' , fnName : 'save'}],
        'add' : [{text : '新建保存' , fnName : 'save'}]
    },
    /*
     * grid数据列表的头部定义*/
    _listGridHeader : [
        { header: '序号',width: 80,  dataIndex: 'id' } ,
        { header: '债权名称',width: 160,   dataIndex: 'product_name'} ,
        { header: '债权状态', width: 160,  dataIndex: 'status',renderer:function(v){
            if(v == 1){
                return '待审核';
            }else if(v == 2){
                return '待发布';
            }else if(v == 3){
                return '审核退回';
            }else if(v == 4){
                return '待销售';
            }else if(v == 5){
                return '销售中';
            }else if(v == 6){
                return '已售罄';
            }
            return v;
        } } ,
        { header: '录入时间', width: 160,  dataIndex: 'dat_create' } 
    ] ,
    //_addInfo : [],
    _viewInfo : [],
    //_addInfo : [],
    _sub_win_defparams : { width:700 , height:500  , maximizable : true },  //子窗口初始参数
    
    _publicInfo : [
        {
            title : '基本信息',
            // typeMode : ["view","edit","add"],
            xtype : 'form',
            layout : 'column',
            padding : 10,
            autoScroll : true,
            mySamle: "theBasePanel",
            items :[
                {
                    fieldLabel : '债权ID',
                    labelWidth: 70,
                    name : 'id',
                    margin: 6,
                    columnWidth :1,
                    hidden:true,
                    readOnly:true,
                    filedType : 'Number'
                },{
                    fieldLabel : '债权名称',
                    labelWidth: 70,
                    name : 'product_name',
                    columnWidth :.5,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    allowBlank:false,
                    blankText:"请选择产品名称",
                    margin: 6,

                    filedType : 'Text'
                },{
                    fieldLabel : '借款人姓名',
                    labelWidth: 90,
                    name : 'borrower',
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    allowBlank:false,
                    blankText:"请选择借款人姓名",
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '证件类型',
                    labelWidth: 70,
                    name : 'cod_card_type',
                    allowBlank :false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请选择证件类型",
                    columnWidth :.5,
                    margin: 6,
                    editable:false,
                    filedType : 'ComboBox',
                    displayField    : 'title',
                    valueField  : "id",
                    value:1,
                    store : new Ext.data.ArrayStore({
                        fields  :   ['id', 'title'],
                        data    :   [[1,'身份证']],
                        // proxy: Ext.create( 'ui.extend.base.Ajax',{
                        //     url : '../claims/cfMastSelect'
                        // })
                    })

                }
                ,{
                    fieldLabel : '证件号码',
                    labelWidth: 70,
                    name : 'cod_card_no',
                    columnWidth :.5,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    allowBlank:false,
                    blankText:"请选择证件号码",
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '手机号码',
                    labelWidth: 70,
                    name : 'telephone',
                    columnWidth :.5,

                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    allowBlank:false,
                    blankText:"请输入手机号码",
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '住所',
                    labelWidth: 70,
                    name : 'address',

                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    allowBlank:false,
                    blankText:"请输入住所",
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                },
                {
                    fieldLabel : '资产包类型',
                    labelWidth: 90,
                    name : 'type',
                    allowBlank :false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请选择资产包类型",
                    columnWidth :.5,
                    margin: 6,
                    editable:false,
                    filedType : 'ComboBox',
                    displayField    : 'title',
                    valueField  : "id",
                    store : new Ext.data.ArrayStore({
                        fields  :   ['id', 'title'],
                        data    :   [[1,'债权资产包'],[2,'收益权资产包']]
                    })
                },
                {
                    fieldLabel : '资产包',
                    labelWidth: 80,
                    name : 'capitalpool_name',
                    allowBlank :false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请选择资产包",
                    columnWidth :.5,
                    margin: 6,
                    editable:false,
                    filedType : 'ComboBox',
                    displayField    : 'name',
                    valueField  : "id",
                    store :  new  Ext.data.ArrayStore({
                        fields  :   ['id', 'name'],
                        data    :   []
                    })
                },
                {
                    fieldLabel : '金额',
                    labelWidth: 70,
                    name : 'amt_cf_inv_price',

                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    columnWidth :.5,
                    allowBlank:false,
                    blankText:"请输入金额",
                    margin: 6,
                    minValue:0,
                    filedType : 'Number'
                },{
                    fieldLabel : '期数',
                    labelWidth: 70,
                    name : 'period',
                    columnWidth :.5,
                    margin: 6,
                    minValue:0,
                    filedType : 'Number'
                },{
                    fieldLabel : '年化收益率',
                    labelWidth: 90,
                    name : 'rat_cf_inv_min',
                    columnWidth :.5,
                    margin: 6,
                    step:0.01,
                    minValue:0,
                    filedType : 'Number'
                },{
                    fieldLabel : '还款方式',
                    labelWidth: 70,
                    name : 'repay',
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                },{
                    fieldLabel : '开始日期',
                    labelWidth: 70,
                    name : 'startdate',
                    columnWidth :.5,
                    margin: 6,
                    allowBlank:false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请选择开始日期",
                    format:'Y-m-d',
                    submitFormat:'Y-m-d',
                    filedType : 'Date'
                },{
                    fieldLabel : '结束日期',
                    labelWidth: 70,
                    name : 'enddate',
                    columnWidth :.5,
                    allowBlank:false,
                    beforeLabelTextTpl:'<span style="color:red">*</span>',
                    blankText:"请选择结束日期",
                    margin: 6,
                    submitFormat:'Y-m-d',
                    format:'Y-m-d',
                    filedType : 'Date'
                },{
                    fieldLabel : '所在城市',
                    labelWidth: 70,
                    name : 'city',
                    columnWidth :.5,
                    margin: 6,
                    filedType : 'Text'
                },
                {
                    fieldLabel : '借款用途',
                    labelWidth: 70,
                    name : 'use',
                    columnWidth :1,
                    margin: 6,
                    filedType : 'TextArea'
                }
            ]
        }
        // ,{
        //     title : '附件',
        //     typeMode : ["view"],
        //     xtype : 'form',
        //     layout : 'column',
        //     padding : 10,
        //     autoScroll : true,
        //     items :[
                
        //     ]
        // }
    ]
});