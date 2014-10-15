/**
 * Pimcore Startup Class
 *
 * @author     Dominik Pfaffenbauer <dominik@pfaffenbauer.at>
 * @copyright  2014 Dominik Pfaffenbauer
 * @license    http://www.wtfpl.net/ Do What the Fuck You Want to Public License
 * @version    Release: 0.1
 */

pimcore.registerNS("pimcore.plugin.logger");

pimcore.plugin.logger = Class.create(pimcore.plugin.admin,{


    getClassName: function (){
        return "pimcore.plugin.logger";
    },

    initialize: function(){
		pimcore.plugin.broker.registerPlugin(this);
	},

    uninstall: function(){
        //TODO remove from menu
    },

    pimcoreReady: function (params,broker) {
        //if(pimcore.globalmanager.get("user").isAllowed("plugin_logger")) {
            pimcore.globalmanager.get("layout_toolbar").extrasMenu.add({
                text: t("Log"),
                iconCls: "logger_icon",
                handler: function () {

                    try {
                        pimcore.globalmanager.get("logger").activate();
                    }
                    catch (e) {
                        //console.log(e);
                        pimcore.globalmanager.add("logger", new pimcore.plugin.logger.panel());
                    }
                }
            });

        //}
    }

});

new pimcore.plugin.logger();