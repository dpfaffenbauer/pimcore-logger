/**
 * Logger Panel
 *
 * @author     Dominik Pfaffenbauer <dominik@pfaffenbauer.at>
 * @copyright  2014 Dominik Pfaffenbauer
 * @license    http://www.wtfpl.net/ Do What the Fuck You Want to Public License
 * @version    Release: 0.1
 */

pimcore.registerNS("pimcore.plugin.logger.panel");
pimcore.plugin.logger.panel = Class.create({

    initialize: function () {
        this.getTabPanel();
        
        this.panels = [];
    },

    getTabPanel: function () {

        if (!this.panel) {
            this.panel = new Ext.Panel({
                id: "logger_panel",
                iconCls: "logger_icon",
                title: t("Logger"),
                border: false,
                layout: "border",
                closable:true,
                items: [this.getGridPanel()]
            });

            var tabPanel = Ext.getCmp("pimcore_panel_tabs");
            tabPanel.add(this.panel);
            tabPanel.activate("logger_panel");


            this.panel.on("destroy", function () {
                pimcore.globalmanager.remove("logger_panel");
            }.bind(this));

            pimcore.layout.refresh();
        }

        return this.panel;
    },

    getGridPanel : function()
    {
        this.store = new Ext.data.JsonStore({
            fields: [
               {name: 'id'},
               {name: 'level'},
               {name: 'text'},
               {name: 'date', type:'date', dateFormat : 'd.m.Y H:i'},
               {name: 'class'},
               {name: 'method'}
            ],
            remoteSort: true,
            url: '/plugin/Logger/admin/get-messages',
            root : 'messages',
            totalProperty : 'total',
            idProperty : 'id',
            autoLoad : true
        });
        
        this.grid = new Ext.grid.GridPanel({
            store: this.store,
            region : 'center',
            columns: [
                {
                    header   : 'ID', 
                    width    : 40, 
                    sortable : true, 
                    dataIndex: 'id'
                },
                {
                    header   : 'Level', 
                    width    : 80, 
                    sortable : true, 
                    dataIndex: 'level'
                },
                {
                    header   : 'Text', 
                    width    : 600, 
                    sortable : true, 
                    dataIndex: 'text'
                },
                {
                    header   : 'Date', 
                    width    : 100, 
                    sortable : true, 
                    dataIndex: 'date',
                    renderer : Ext.util.Format.dateRenderer('d.m.Y H:i')
                },
                {
                    header   : 'Class', 
                    width    : 100, 
                    sortable : true, 
                    dataIndex: 'class'
                },
                {
                    header   : 'Method',
                    width    : 100, 
                    sortable : true, 
                    dataIndex: 'method'
                }
            ],
            stripeRows: true,
            stateId: 'grid',
            bbar: new Ext.PagingToolbar({
                pageSize: 40,
                store: this.store,
                displayInfo: true,
                emptyMsg: t("error_log_no_search_results"),
                items:[]
            })
        });
        
        //this.store.load();
        
        return this.grid;
    }
});