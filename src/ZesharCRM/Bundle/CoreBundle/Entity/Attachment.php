<?php

namespace ZesharCRM\Bundle\CoreBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Attachment
 */
class Attachment
{
    
    public static $server_path_to_file_folder = WEB_DIRECTORY;
    public static $basePath = BASE_PATH;
    
    public function __construct() {
        self::$server_path_to_file_folder = WEB_DIRECTORY . '/uploads/attachments';
        self::$basePath = BASE_PATH;
    }
    
    /**
     * @var integer
     */
    private $id;

    /**
     * @var string
     */
    private $text;

    /**
     * @var string
     */
    private $file;
    
    private $filename;
    
    public function getFilename()
    {
        return $this->filename;
    }
    
    public function setFilename($filename)
    {
        $this->filename = $filename;
    }


    private $objectId;
    private $objectType;
    
    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set text
     *
     * @param string $text
     * @return Attachment
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }

    /**
     * Get text
     *
     * @return string 
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set filename
     *
     * @param string $filename
     * @return Attachment
     */
    public function setFile(/*UploadedFile*/ $file = null)
    {
        $this->file = $file;

        return $this;
    }

    /**
     * Get filename
     *
     * @return string 
     */
    public function getFile()
    {
        return $this->file;
    }
    
    public function getDownloadUrl()
    {
        return self::$basePath . '/uploads/attachments/' . $this->getFile();
    }
    
    /**
    * Manages the copying of the file to the relevant place on the server
    */
   public function upload()
   {
       // the file property can be empty if the field is not required
       if (null === $this->getFile()) {
           $this->filename = null;
           return;
       }

       if ($this->getFilename()) {
           return;
       }

       // we use the original file name here but you should
       // sanitize it at least to avoid any security issues

       // move takes the target directory and target filename as params
       $originalFileName = $this->getFile()->getClientOriginalName();
       $extension = substr($originalFileName, strrpos($originalFileName, '.') + 1);
       $newFilename = md5($originalFileName . microtime(TRUE)) . '_' . mt_rand(0, 100000) . '.' . $extension;
       $this->getFile()->move(
           self::$server_path_to_file_folder,
           $newFilename
       );

       
       $this->filename = $originalFileName;

       $this->file = $newFilename;
   }

   /**
    * Lifecycle callback to upload the file to the server
    */
   public function lifecycleFileUpload() {
       $this->upload();
   }
   
   /**
     * Set createdAt
     *
     * @param \DateTime $createdAt
     * @return Attachment
     */
    public function setCreatedAt($createdAt)
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * Get createdAt
     *
     * @return \DateTime 
     */
    public function getCreatedAt()
    {
        return $this->createdAt;
    }

    /**
     * Set updatedAt
     *
     * @param \DateTime $updatedAt
     * @return Attachment
     */
    public function setUpdatedAt($updatedAt)
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    /**
     * Get updatedAt
     *
     * @return \DateTime 
     */
    public function getUpdatedAt()
    {
        return $this->updatedAt;
    }
    
    /**
     * @var \DateTime
     */
    private $createdAt;

    /**
     * @var \DateTime
     */
    private $updatedAt;
    
    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\User
     */
    private $creator;

    /**
     * Set creator
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\User $creator
     * @return Attachment
     */
    public function setCreator(\ZesharCRM\Bundle\CoreBundle\Entity\User $creator = null)
    {
        $this->creator = $creator;

        return $this;
    }
    
    /**
     * @var \ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment
     */
    private $leadAttachment;
    
    private $opportunityAttachment;


    /**
     * Set leadAttachment
     *
     * @param \ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment $leadAttachment
     * @return Attachment
     */
    public function setLeadAttachment(\ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment $leadAttachment = null)
    {
        $this->leadAttachment = $leadAttachment;

        return $this;
    }

    
    public function getOpportunityAttachment()
    {
        return $this->opportunityAttachment;
    }
    
    
    public function setOpportunityAttachment(\ZesharCRM\Bundle\CoreBundle\Entity\OpportunityAttachment $opportunityAttachment = null)
    {
        $this->opportunityAttachment = $opportunityAttachment;

        return $this;
    }

    /**
     * Get leadAttachment
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\LeadAttachment 
     */
    public function getLeadAttachment()
    {
        return $this->leadAttachment;
    }

    /**
     * Get creator
     *
     * @return \ZesharCRM\Bundle\CoreBundle\Entity\User 
     */
    public function getCreator()
    {
        return $this->creator;
    }
    
    public function __toString()
    {
        return $this->getText() ?: 'No text';
    }
    
    public function getDownloadLink()
    {
        $output = '';
        if ( $this->getFile() && ($url = $this->getDownloadUrl()) ) {
            $output .= '<a href="' . $url . '">';
            if ($name = $this->getFilename()) {
                $output .= $name;
            } else {
                $output .= '[ Download File ]';
            }
            $output .= '</a>';
        }
        return $output;
    }
    
}
