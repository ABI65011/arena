<?php

namespace App\Helpers;

enum AppEnums: string
{

} 

enum ProgrammeLevels : string
{
    case Certificate = 'Certificate';
    case Diploma = 'Diploma';
    case Degree = 'Degree';
    case Postgraduate = 'Postgraduate';
}
enum Gender : string
{
    case Male = 'Male';
    case Female = 'Female';
}

enum Month: string
{
    case January = 'January';
    case February = 'February';
    case March = 'March';
    case April = 'April';
    case May = 'May';
    case June = 'June';
    case July = 'July';
    case August = 'August';
    case September = 'September';
    case October = 'October';
    case November = 'November';
    case December = 'December';
}

enum ReferralSource: string
{
    case Radio = 'Radio';
    case Tv = 'TV';
    case SocialMedia = 'Social Media';
}

enum MaritalStatus: string
{
    case Single = 'Single';
    case Married = 'Married';
    case Other = 'Other';
}

enum ApplicationType: string
{
    case Undergraduate = 'Undergraduate';
    case Postgraduate = 'Postgraduate';
}

enum ApplicationStatus: string
{
    case Draft = 'Draft';
    case Submitted = 'Submitted';
    case UnderReview = 'Under Review';
    case Accepted = 'Accepted';
    case Rejected = 'Rejected';
    case Waitlisted = 'Waitlisted';
}

enum Priority: string
{
    case First = '1st';
    case Second = '2nd';
}

enum StudyMode: string
{
    case Day = 'Day';
    case Weekend = 'Weekend';
    case Recess = 'Recess';
}

enum ApplicationGuardianType: string
{
    case Father = 'Father';
    case Mother = 'Mother';
    case Sponsor = 'Sponsor';
}

enum ValidationStatus: string
{
    case Pending = 'Pending';
    case Valid = 'Valid';
    case Invalid = 'Invalid';
}

enum RuleType: string
{
    case MinSubjects = 'Min Subjects';
    case MinGrade = 'Min Grade';
    case MinPoints = 'Min Points';
    case RequiredSubject = 'Required Subject';
}

enum ReviewAssignmentStatus: string
{
    case Pending = 'Pending';
    case InReview = 'In Review';
    case Completed = 'Completed';
}

enum Decision: string
{
    case Approved = 'Approved';
    case Rejected = 'Rejected';
    case Waitlisted = 'Waitlisted';
}

enum AdmissionLetterType: string
{
    case Offer = 'Offer';
    case Rejection = 'Rejection';
}

enum Channel: string
{
    case Sms = 'Sms';
    case Email = 'Email';
}

enum NotificationLogStatus: string
{
    case Pending = 'Pending';
    case Sent = 'Sent';
    case Failed = 'Failed';
}

