<?php 
namespace Robin\Banner\Setup;
use Magento\Framework\Setup\SchemaSetupInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\DB\Ddl\Table;

class InstallSchema implements \Magento\Framework\Setup\InstallSchemaInterface
{
  
    public function install(SchemaSetupInterface $setup, ModuleContextInterface $context)
    {
        $setup->startSetup();
        //tạo 1 biến để kết nối tới database
        $connection=$setup->getConnection();
        $tableName=$setup->getTable("banner");
        if(!$connection->isTableExists($tableName))
        {
        	    $table=$connection->newTable($tableName)->addColumn(
        	"id",
        	Table::TYPE_INTEGER,
        	null,
        	["primary"=>true,"nullable"=>false,"identity"=>true ]
        )->addColumn(
        	"image",
        	Table::TYPE_TEXT,
        	255,
        	["nullable"=>false]
        )->addColumn(
        	"link",
        	Table::TYPE_TEXT,
        	255,
        	["nullable"=>false]
        )->setOption("charset","utf8");
        $connection->createTable($table);
        }
    

        $setup->endSetup();
        
    }
}

 ?>