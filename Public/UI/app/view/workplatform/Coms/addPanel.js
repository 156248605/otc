/**
 * Created by Administrator on 2015/12/24 0024.
 */
Ext.define('ui.view.workplatform.Coms.addPanel', {
    extend: 'ui.extend.baseClass.coms.baseBusTabPanel',
    alias: 'widget.workplatformaddpanel',
    opTitle : '新增',
    
    initComponent : function(){
        var me = this;
        me.formsList = [];
        me.ctrl.$assembleInfoPanel.call(me.ctrl,me,'add');
        this.callParent(arguments);

        for(var i=0 ; i<this.formsList.length; i++){
            this.addPanel(this.formsList[i]);
        }
    }
});