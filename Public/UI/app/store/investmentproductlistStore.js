/**
 * Created by Administrator on 2015/12/14 0014.
 */

Ext.define('ui.store.investmentproductlistStore',{
    extend : 'ui.extend.base.Store',
    fields : [
        'id',
        'dat_modify',
        'bidname',
        'ctr_ct_finish',
        'cod_cf_status',
        'investcounts',
        'amt_ct',
        'allp2',
        'cod_period'
        
    ]
});
/*
Ext.create('Ext.data.Store', {
    storeId:'simpsonsStore',
    fields:['name', 'email', 'phone'],
    data:{'items':[
        { 'name': 'Lisa',  "email":"lisa@simpsons.com",  "phone":"555-111-1224"  },
        { 'name': 'Bart',  "email":"bart@simpsons.com",  "phone":"555-222-1234" },
        { 'name': 'Homer', "email":"home@simpsons.com",  "phone":"555-222-1244"  },
        { 'name': 'Marge', "email":"marge@simpsons.com", "phone":"555-222-1254"  }
    ]},
    proxy: {
        type: 'memory',
        reader: {
            type: 'json',
            root: 'items'
        }
    }
});
*/