<form method="post">
    @csrf
    <div>
        <label>New password</label>
        <input type="text" name="password">
    </div>
    <div>
        <label>Confirm new password</label>
        <input type="text" name="password_confirmation">
    </div>
    <button type="submit">Reset Password</button>
</form>