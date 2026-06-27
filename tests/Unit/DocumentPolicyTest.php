<?php

namespace Tests\Unit;

use App\Models\Document;
use App\Models\Team;
use App\Models\User;
use App\Policies\DocumentPolicy;
use PHPUnit\Framework\TestCase;

class DocumentPolicyTest extends TestCase
{
    protected $policy;
    protected $user;
    protected $otherUser;
    protected $document;
    protected $team;

    protected function setUp(): void
    {
        parent::setUp();
        $this->policy = new DocumentPolicy();
        $this->user = new User(['id' => 1]);
        $this->otherUser = new User(['id' => 2]);
        $this->document = new Document(['user_id' => 1, 'team_id' => null]);
    }

    /**
     * Test owner can view document
     */
    public function test_owner_can_view_document(): void
    {
        $this->assertTrue($this->policy->view($this->user, $this->document));
    }

    /**
     * Test non-owner cannot view personal document
     */
    public function test_non_owner_cannot_view_personal_document(): void
    {
        $this->assertFalse($this->policy->view($this->otherUser, $this->document));
    }

    /**
     * Test owner can update document
     */
    public function test_owner_can_update_document(): void
    {
        $this->assertTrue($this->policy->update($this->user, $this->document));
    }

    /**
     * Test non-owner cannot update document
     */
    public function test_non_owner_cannot_update_document(): void
    {
        $this->assertFalse($this->policy->update($this->otherUser, $this->document));
    }

    /**
     * Test owner can delete document
     */
    public function test_owner_can_delete_document(): void
    {
        $this->assertTrue($this->policy->delete($this->user, $this->document));
    }

    /**
     * Test non-owner cannot delete document
     */
    public function test_non_owner_cannot_delete_document(): void
    {
        $this->assertFalse($this->policy->delete($this->otherUser, $this->document));
    }

    /**
     * Test owner can download document
     */
    public function test_owner_can_download_document(): void
    {
        $this->assertTrue($this->policy->download($this->user, $this->document));
    }

    /**
     * Test non-owner cannot download personal document
     */
    public function test_non_owner_cannot_download_personal_document(): void
    {
        $this->assertFalse($this->policy->download($this->otherUser, $this->document));
    }
}