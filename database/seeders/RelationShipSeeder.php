<?php

namespace Database\Seeders;

use App\Models\AssociateRelationship;
use Illuminate\Database\Seeder;

class RelationShipSeeder extends Seeder
{
    public function run(): void
    {
        AssociateRelationship::create([
            'relationship' => 'Parent',
            'description' => 'Mother, Father',
        ]);

        AssociateRelationship::create([
            'relationship' => 'Child',
            'description' => 'Son, Daughter, Adopted etc...',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Sibling',
            'description' => 'Brother, Sister, Step Sibling',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Spouse',
            'description' => 'Husband, Wife, Partner',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Grand Parent',
            'description' => 'Grandmother, Grandfather',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Aunt/Uncle',
            'description' => 'Aunt, Uncle, Step Aunt, Step Uncle',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Niece/Nephew',
            'description' => 'Niece, Nephew, Step Niece, Step Nephew',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Cousin',
            'description' => 'Cousin, Step Cousin',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Mother-in-law/Father-in-law',
            'description' => 'Mother-in-law, Father-in-law',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Sister-in-law/Brother-in-law',
            'description' => 'Sister-in-law, Brother-in-law',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Son-in-law/Daughter-in-law',
            'description' => 'Son-in-law, Daughter-in-law',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Dating Partner',
            'description' => 'Partner',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Fiance',
            'description' => 'Fiance, Engaged',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Boyfriend/Girlfriend',
            'description' => 'Boyfriend, Girlfriend',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Lover',
            'description' => 'Not married or attached but intimate',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Live Partner',
            'description' => 'Commited Partner',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Best Friend',
            'description' => 'Best Friend',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Close Friend',
            'description' => 'Close fiend',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Casual Friend',
            'description' => 'Acquaintance',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Confidant',
            'description' => 'Someone to confide in',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Colleague',
            'description' => 'Work together',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Manager/Supervisor',
            'description' => 'Manager, Supervisor',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Employee/Subordinate',
            'description' => 'Employee, Subordinate',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Mentor/Mentee',
            'description' => 'Mentor, Mentee',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Business Partner',
            'description' => 'Business Partner',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Client/Customer',
            'description' => 'Client or Customer',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Supplier/Service Provider',
            'description' => 'Provider or Supplier',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Neighbor',
            'description' => 'Neighbor',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Fellow Member',
            'description' => 'In a club, organization, or church',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Teacher',
            'description' => 'Teacher',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Student',
            'description' => 'Student',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Classmate',
            'description' => 'Classmate',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Advisor',
            'description' => 'School Advisor',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Stranger',
            'description' => 'Unknown before today',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Bystander',
            'description' => 'Someone who is unknown to the subject',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Online Friend',
            'description' => 'Virtual friend',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Customer/Client',
            'description' => 'A customer or client',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Vendor/Seller',
            'description' => 'A vendor or seller',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Doctor/Healthcare Professional',
            'description' => 'Doctor or Healthcare Professional',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Patient',
            'description' => 'A patient of the subject',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Lawyer/Attorney',
            'description' => 'Lawyer or Attorney',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Guru/Disciple',
            'description' => 'Spiritual Guru or Disciple',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Spiritual Mentor/Seeker',
            'description' => 'A spiritual mentor or seeker',
        ]);
        AssociateRelationship::create([
            'relationship' => 'Hostage',
            'description' => 'Actively being held by subject.',
        ]);
    }
}
