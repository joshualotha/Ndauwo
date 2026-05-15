<x-mail::message>
# New Inquiry Received

**Name:** {{ $inquiry->name }}  
**Email:** {{ $inquiry->email }}  
**Phone:** {{ $inquiry->phone ?? 'N/A' }}  

**Travel Date:** {{ $inquiry->travel_date ?? 'Flexible' }}  
**Travelers:** {{ $inquiry->adults }} Adults, {{ $inquiry->children }} Children  

**Message:**  
{{ $inquiry->message }}

<x-mail::button :url="config('app.frontend_url') . '/admin/inquiries/' . $inquiry->id">
View Inquiry
</x-mail::button>

Thanks,<br>
{{ config('app.name') }} System
</x-mail::message>
