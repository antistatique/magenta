<?php


/**
 * Skeleton subclass for performing query and update operations on the 'project' table.
 *
 * 
 *
 * You should add additional methods to this class to meet the
 * application requirements.  This class will only be generated as
 * long as it does not already exist in the output directory.
 *
 * @package    lib.model
 */
class ProjectPeer extends BaseProjectPeer {
  /**
   * Constant which define the project_type
   * 
   * @var string TYPE_WEBSITE
   * @var string TYPE_ECOM
   * @var string TYPE_WEBAPP
   * @var string TYPE_SEO
   * @var string TYPE_GIS
   * @var string TYPE_CORPORATE
   * @var string TYPE_PRINT
   * @var string TYPE_FLYER      
   * @var array project_type   
   */
  const TYPE_WEBSITE    = "website";
  const TYPE_ECOM       = "ecom";
  const TYPE_WEBAPP     = "webapp";
  const TYPE_BANNER     = "banner";
  const TYPE_SEO        = "seo";
  const TYPE_GIS        = "gis";
  const TYPE_CORPORATE  = "corporate";
  const TYPE_PRINT      = "print";
  const TYPE_FLYER      = "flyer";
  const TYPE_NEWSLETTER = "newsletter";
  const TYPE_MULTIMEDIA = "multimedia";
  const TYPE_GRAPHICS   = "graphics";
  const TYPE_OTHERS   = "others";


  protected static $project_type = array(
    self::TYPE_WEBSITE   => 'Site Internet',
    self::TYPE_ECOM      => 'E-Commerce',
    self::TYPE_WEBAPP    => 'Application web',
    self::TYPE_BANNER    => 'Bannière',    
    self::TYPE_SEO       => 'SEO',
    self::TYPE_GIS       => 'GIS',
    self::TYPE_CORPORATE => 'Corporate identity',
    self::TYPE_PRINT     => 'Print',
    self::TYPE_FLYER     => 'Flyer',
    self::TYPE_NEWSLETTER => 'Newsletter',
    self::TYPE_MULTIMEDIA => 'Multimedia',
    self::TYPE_GRAPHICS   => 'Graphisme',
    self::TYPE_OTHERS      => 'Autres',
  );
  
  /**
   * Return an array of workflow types
   * @return array of workflow types
   */
  public static function getTypeProjects()
  {
    return self::$project_type;
  }
  
  
  /**
   * Return the highest number field of all project and add 1
   * @return int number of the last project + 1 
   */
  public static function getNextNumber()
  {
    $c = new Criteria();
    $c->addDescendingOrderByColumn(ProjectPeer::NUMBER);
    $project = self::doSelectOne($c);
    if(!$project)
    {
       return 1;
    }
    
    return $project->getNumber()+1;
  }
  
} // ProjectPeer
