/**
 * Created by Administrator on 2015/12/15 0015.
 */

Ext.define('ui.view.foundationlist.Coms.ListGrid',{
    extend: 'ui.extend.base.Panel',
    alias: 'widget.foundationlistpagecentergrid',
    requires :[
        'ui.extend.base.Grid',
        'ui.extend.base.Paging'
    ],
    constructor : function(cfg){
        var me  = this;
        this.ctrl = cfg.ctrl;
//定义数据源store
        var url = this.ctrl.$getConfig('urls').get('get.foundationlist.list').url;
        this.store = Ext.create( 'ui.store.debtStore' , {
            fields : [],
            ctrl : this.ctrl,
            autoLoad: { params: {} },
            proxy : Ext.create( 'ui.extend.base.Ajax',{
                url : url    //"/Public/jsons/get.all.foundationlist.record.json",
                
            }),
            listeners : {
               load:function(store,records,success,obts){
                    if(success){
                        var resultJson=Ext.decode(obts._response.responseText);
                        //console.log(resultJson);
                        var scFields=me.ctrl.fieldsArray
                        for(var i=0;i<scFields.length;i++){
                            if(scFields[i].isSummary==1){
                                var summaryName=scFields[i].summaryName;
                                // console.log();
                                scFields[i].setValue(resultJson[summaryName]);
                                //scFields[i].setValue('qaa');
                            }
                        }
                    }
                    // console.log(cfg);
                    // console.log(store);
                    // console.log(success);
                    

               }
            }
        });
        
//定义checkboxModel
        var sm = Ext.create('Ext.selection.CheckboxModel',{});
        //var searchFields  = this.ctrl.$getFeildListArray();
        this.form = Ext.create('Ext.form.Panel',{
            xtype : 'form',
            layout : "column",
            myid : 'ListGridForm',
            bodyStyle : 'padding:10px;',
            border : 0,
            items : this.ctrl.$getFeildListArray()
        });
//定义字段列表
//定义字段列表
        var cmconfig = [];
        cmconfig = cmconfig.concat(me.ctrl.$getConfig('_listGridHeader'));
        cmconfig = cmconfig || [];
        cmconfig.push({
            header: '操作', width: 250, dataIndex: 'oprations',
            renderer: function (v,p,record){
                setTimeout(function(){
                    me.ctrl.$initListBtnEvents( me.store , me.grid , me.ctrl );
                },100);
                return me.ctrl.$getListOperationBtns(v, p, record, me.ctrl);
            }
        });
        //console.log(cmconfig);
        var cm = cmconfig;
//定义gridpanel
        this.grid = Ext.create('ui.extend.base.Grid',{
            myid : 'ListGrid',
            alias: ["widget.foundationlistlistgrid"],
            selModel: sm,
            tbar : this.form,
            border : 0,
            store: this.store,
            dockedItems: [{
                xtype: 'gridpagingtoolbar',
                store: this.store,   // GridPanel中使用的数据
                dock: 'bottom',
                displayInfo: true
            }],
            columns: cm,
            listeners : {
                rowcontextmenu : function(grid,record, htm , rowIndex ,e){
                    e.stopEvent();
                    e.preventDefault(); //覆盖默认右键
                    me.ctrl.$gridRightMenuInit.call(me.ctrl,grid,record,e);
                },
                rowdblclick : function(){
                    //me.ctrl.
                }
            }
        });

        var defaultparams = {
            region : 'center',
            layout: 'fit',
            html : '&nbsp;',
            baseCls : 'my-panel-no-border',
            items : [this.grid]
        };

        var param = defaultparams || {};
        Ext.apply(this,param);
        this.callParent(arguments);
    },

    initComponent : function(){
        this.callParent(arguments);
    }

});