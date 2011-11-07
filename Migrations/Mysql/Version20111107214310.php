<?php
namespace TYPO3\FLOW3\Persistence\Doctrine\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration,
	Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your need!
 */
class Version20111107214310 extends AbstractMigration {

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function up(Schema $schema) {
			// this up() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		
		$this->addSql("ALTER TABLE admin_domain_model_tag_tags_inlines_join DROP FOREIGN KEY FK_350A686A59646648");
		$this->addSql("DROP INDEX IDX_350A686A59646648 ON admin_domain_model_tag_tags_inlines_join");
		$this->addSql("ALTER TABLE admin_domain_model_tag_tags_inlines_join DROP PRIMARY KEY");
		$this->addSql("ALTER TABLE admin_domain_model_tag_tags_inlines_join CHANGE admin_widgets admin_inline VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE admin_domain_model_tag_tags_inlines_join ADD CONSTRAINT FK_350A686A15A36C0E FOREIGN KEY (admin_inline) REFERENCES admin_domain_model_inline(flow3_persistence_identifier)");
		$this->addSql("CREATE INDEX IDX_350A686A15A36C0E ON admin_domain_model_tag_tags_inlines_join (admin_inline)");
		$this->addSql("ALTER TABLE admin_domain_model_tag_tags_inlines_join ADD PRIMARY KEY (admin_tag, admin_inline)");
		$this->addSql("ALTER TABLE admin_domain_model_widgets ADD resource VARCHAR(40) DEFAULT NULL, DROP autoexpand");
		$this->addSql("ALTER TABLE admin_domain_model_widgets ADD CONSTRAINT FK_967CD45BBC91F416 FOREIGN KEY (resource) REFERENCES typo3_flow3_resource_resource(flow3_persistence_identifier)");
		$this->addSql("CREATE UNIQUE INDEX UNIQ_967CD45BBC91F416 ON admin_domain_model_widgets (resource)");
	}

	/**
	 * @param Schema $schema
	 * @return void
	 */
	public function down(Schema $schema) {
			// this down() migration is autogenerated, please modify it to your needs
		$this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql");
		
		$this->addSql("ALTER TABLE admin_domain_model_tag_tags_inlines_join DROP FOREIGN KEY FK_350A686A15A36C0E");
		$this->addSql("DROP INDEX IDX_350A686A15A36C0E ON admin_domain_model_tag_tags_inlines_join");
		$this->addSql("ALTER TABLE admin_domain_model_tag_tags_inlines_join DROP PRIMARY KEY");
		$this->addSql("ALTER TABLE admin_domain_model_tag_tags_inlines_join CHANGE admin_inline admin_widgets VARCHAR(40) NOT NULL");
		$this->addSql("ALTER TABLE admin_domain_model_tag_tags_inlines_join ADD CONSTRAINT FK_350A686A59646648 FOREIGN KEY (admin_widgets) REFERENCES admin_domain_model_widgets(flow3_persistence_identifier)");
		$this->addSql("CREATE INDEX IDX_350A686A59646648 ON admin_domain_model_tag_tags_inlines_join (admin_widgets)");
		$this->addSql("ALTER TABLE admin_domain_model_tag_tags_inlines_join ADD PRIMARY KEY (admin_tag, admin_widgets)");
		$this->addSql("ALTER TABLE admin_domain_model_widgets DROP FOREIGN KEY FK_967CD45BBC91F416");
		$this->addSql("DROP INDEX UNIQ_967CD45BBC91F416 ON admin_domain_model_widgets");
		$this->addSql("ALTER TABLE admin_domain_model_widgets ADD autoexpand VARCHAR(255) DEFAULT NULL, DROP resource");
	}
}

?>